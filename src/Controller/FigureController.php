<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Entity\MediaGroupe;
use App\Form\CommentFormType;
use App\Form\FigureFormType;
use App\Repository\FigureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

class FigureController extends AbstractController
{

    #[Route('/api/figures/{offset}')]
    public function getFiguresFrom($offset, EntityManagerInterface $em, FigureRepository $figureRepository): JsonResponse
    {
        $start = (int)$offset;
        $data = $figureRepository->loadMoreCards($start, $em);

        return new JsonResponse($data, Response::HTTP_OK, [], false);
    }

    #[Route('/figures', name: 'app_figures')]
    public function displayFigures(FigureRepository $figureRepository): Response
    {
        $figures = $figureRepository->findAll();

        return $this->render('figure/figures.html.twig', [
            'figures' => $figures,
        ]);
    }

    #[Route('/figure/show/{slug}', name: 'app_figure')]
    public function displayFigure($slug, FigureRepository $figureRepository, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $figure = $figureRepository->findOneBy(['slug' => $slug]);

        if (!$figure) {
            return $this->render('figure/not_found.html.twig');
        }

        // création du formulaire de commentaire
        $comment = new Comment();
        $formComment = $this->createForm(CommentFormType::class, $comment);
        $formComment->handleRequest($request);

        // Envoie du formulaire de commentaire
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $newComment = $formComment->getData();
            $newComment->setDate(new DateTime());
            $newComment->setUser($this->getUser());
            $newComment->setFigure($figure);

            $entityManager->persist($newComment);
            $entityManager->flush();
            return $this->redirectToRoute('app_figure', ['slug' => $figure->getSlug()]);
        }

        return $this->render('figure/figure.html.twig', [
            'figure' => $figure,
            'formComment' => $formComment->createView(),
            'comments' => $figure->getComments(),
            'medias' => $figure->getMedia()
        ]);
    }

    #[Route('/figure/create', name: 'app_figure_create')]
    public function createFigure(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        //si l'utilisateur n'est pas connecté
        if ($this->getUser() == null) {
            return $this->render('other/connexionRequired.html.twig');
        }

        //création du formulaire
        $figure = new Figure();
        $form = $this->createForm(FigureFormType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //récupération des données du formulaire
            $newFigure = $form->getData();

            //récupération de l'utilisateur
            $currentUser = $this->getUser();

            //affectation de l'utilisateur à la figure
            $newFigure->setUserId($currentUser);

            //date de création = date d'aujourd'hui
            $newFigure->setCreationDate(new DateTime());

            //création du slug pour la recherche
            $newSlug = $slugger->slug($newFigure->getName());

            $newFigure->setSlug($newSlug);

            //enregistrement des données
            $entityManager->persist($newFigure);
            $entityManager->flush();

            //redirection vers la home pages
            return $this->redirectToRoute('app_figures');
        }

        return $this->render('figure/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/figure/edit/{id}', name: 'app_figure_edit')]
    public function editFigure(Figure $figure, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // création du formulaire d'édition de la figure
        $figureForm = $this->createForm(FigureFormType::class, $figure);
        $figureForm->handleRequest($request);

        // Envoie du formulaire de la figure
        if ($figureForm->isSubmitted() && $figureForm->isValid()) {
            $figure->setUpdateDate(new DateTime());
            $newSlug = $slugger->slug($figure->getName());
            $figure->setSlug($newSlug);
            $entityManager->flush();
            return $this->redirectToRoute('app_figure', ['slug' => $figure->getSlug()]);
        }

        return $this->render('figure/edit_figure.html.twig', [
            'figure' => $figure,
            'medias' => $figure->getMedia(),
            'figureForm' => $figureForm->createView()
        ]);
    }

    #[Route('/figure/delete/{id}', name: 'app_figure_delete')]
    public function deleteFigure(Figure $figure, EntityManagerInterface $entityManager): Response
    {
        $figureMedias = $figure->getMedia();

        if ($figureMedias->count() > 0) {
            foreach ($figureMedias as $media) {
                if ($media->getGroupe() == MediaGroupe::photo) {
                    unlink($media->getMediaPath());
                }

                $entityManager->remove($media);
                $entityManager->flush();
            }
        }

        $figureComments = $figure->getComments();

        if ($figureComments->count() > 0) {
            foreach ($figureComments as $comment) {
                $entityManager->remove($comment);
                $entityManager->flush();
            }
        }

        $entityManager->remove($figure);
        $entityManager->flush();

        return $this->redirectToRoute('app_figures');
    }
}
