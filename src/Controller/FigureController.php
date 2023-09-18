<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Entity\Media;
use App\Entity\MediaGroupe;
use App\Form\FigureFormType;
use App\Form\MediaFormType;
use App\Repository\FigureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class FigureController extends AbstractController
{
    #[Route('/figures', name: 'app_figures')]
    public function displayFigures(FigureRepository $figureRepository): Response
    {
        $figures = $figureRepository->findAll();
        //dd($figures[0]->getBanner());
        return $this->render('figure/figures.html.twig', [
            'figures' => $figures,
        ]);
    }

    #[Route('/figure/show/{name}', name: 'app_figure')]
    public function displayFigure(FigureRepository $figureRepository, Request $request): Response
    {
        $dataURL = $request->getPathInfo();
        $name = substr($dataURL, strpos($dataURL, "show") + 5);
        //dd($dataURL, $name);
        $figure = $figureRepository->findOneBy(['name' => $name]);
        return $this->render('figure/figure.html.twig', ['figure' => $figure]);
    }

    #[Route('/figure/create', name: 'app_figure_create')]
    public function createFigure(Request $request, EntityManagerInterface $entityManager): Response
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

            //enregistrement des données
            $entityManager->persist($newFigure);
            $entityManager->flush();

            //redirection vers la home pages
            return $this->redirectToRoute('app_home');
        }

        return $this->render('figure/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/figure/edit/{id}', name: 'app_figure_edit')]
    public function editFigure(Figure $figure, Request $request, EntityManagerInterface $entityManager): Response
    {
        $figureForm = $this->createForm(FigureFormType::class, $figure);
        $figureForm->handleRequest($request);

        // TODO: faire choisir le type de media vidéo ou photo et donc faire différents formulaire en fonction du media
        $media = new Media();
        $mediaForm = $this->createForm(MediaFormType::class, $media);
        $mediaForm->handleRequest($request);
        $mediaPath = $mediaForm->get('media_path')->getData();

        // Envoie du formulaire de la figure
        if ($figureForm->isSubmitted() && $figureForm->isValid()) {
            $figure->setUpdateDate(new DateTime());
            $entityManager->flush();
            return $this->redirectToRoute('app_figure', ['name' => $figure->getName()]);
        }

        //  Envoie du formulaire de bannière
        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {
            //dd($mediaPath, $newMediaExtension);
            $newMedia = $mediaForm->getData();
            if ($mediaPath) {
                //suppression de l'ancienne bannière
                if ($figure->getBanner()) {
                    unlink($figure->getBanner()->getMediaPath());
                    $entityManager->remove($figure->getBanner());
                }
                $newFileName = uniqid() . '.' . $mediaPath->guessExtension();
                try {
                    $mediaPath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/tricksBanner/',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newMedia->setMediaPath('uploads/tricksBanner/' . $newFileName);
                //  la bannière est forcément une photo
                $newMedia->setGroupe(MediaGroupe::photo);
                // firstMedia = true car c'est la bannière
                $newMedia->setFirstMedia(1);
                // attribution du figure id
                $newMedia->setFigure($figure);

                $entityManager->persist($newMedia);
                $entityManager->flush();
            }
        }

        return $this->render('figure/edit_figure.html.twig', [
            'figure' => $figure,
            'figureForm' => $figureForm->createView(),
            'mediaForm' => $mediaForm->createView()
        ]);
    }
}
