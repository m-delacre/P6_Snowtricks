<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Entity\Media;
use App\Entity\MediaGroupe;
use App\Form\CommentFormType;
use App\Form\FigureFormType;
use App\Form\MediaFormType;
use App\Form\VideoFormType;
use App\Repository\FigureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

class FigureController extends AbstractController
{
    #[Route('/figures', name: 'app_figures')]
    public function displayFigures(FigureRepository $figureRepository): Response
    {
        $figures = $figureRepository->findAll();

        return $this->render('figure/figures.html.twig', [
            'figures' => $figures,
        ]);
    }

    #[Route('/figure/show/{slug}', name: 'app_figure')]
    public function displayFigure(FigureRepository $figureRepository, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $dataURL = $request->getPathInfo();

        $name = substr($dataURL, strpos($dataURL, "show") + 5);
        //$slugger = new AsciiSlugger();
        $slug = $slugger->slug($name);
        // $name = urldecode($name);
        //dd("dans l'URL : $dataURL", " resultat après sluger: $name");
        $figure = $figureRepository->findOneBy(['slug' => $slug]);
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
            return $this->redirectToRoute('app_figure', ['name' => $figure->getName()]);
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
            //$slugger = new AsciiSlugger();
            $newSlug = $slugger->slug($newFigure->getName());

            $newFigure->setSlug($newSlug);

            //dd( $newFigure->getSlug());

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
        // création du formulaire d'édition de la figure
        $figureForm = $this->createForm(FigureFormType::class, $figure);
        $figureForm->handleRequest($request);

        // Envoie du formulaire de la figure
        if ($figureForm->isSubmitted() && $figureForm->isValid()) {
            $figure->setUpdateDate(new DateTime());
            $entityManager->flush();
            return $this->redirectToRoute('app_figure', ['name' => $figure->getName()]);
        }

        //création du formulaire d'ajout d'une video
        $video = new Media();
        $videoForm = $this->createForm(VideoFormType::class, $video);
        $videoForm->handleRequest($request);

        //  Envoie du formulaire d'ajout d'une vidéo
        if ($videoForm->isSubmitted() && $videoForm->isValid()) {
            $newVideo = $videoForm->getData();

            // récuparation de l'url
            $fullstring = $newVideo->getMediaPath();
            $parsed = $this->getStringBetween($fullstring, 'src="', '"');

            $newVideo->setMediaPath($parsed);

            // Le groupe ici est photo
            $newVideo->setGroupe(MediaGroupe::video);

            // firstMedia = false car ce n'est pas la bannière
            $newVideo->setFirstMedia(0);

            // attribution du figure id
            $newVideo->setFigure($figure);

            $entityManager->persist($newVideo);
            $entityManager->flush();
        }

        //création du formulaire d'ajout d'une photo
        $photo = new Media();
        $photoForm = $this->createForm(MediaFormType::class, $photo);
        $photoForm->handleRequest($request);
        $photoPath = $photoForm->get('media_path')->getData();

        //  Envoie du formulaire d'ajout de photo
        if ($photoForm->isSubmitted() && $photoForm->isValid()) {
            $newPhoto = $photoForm->getData();
            if ($photoPath) {
                $newFileName = $figure->getId() . '-' . uniqid() . '.' . $photoPath->guessExtension();
                try {
                    $photoPath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/tricksPhoto/',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newPhoto->setMediaPath('uploads/tricksPhoto/' . $newFileName);
                // Le groupe ici est photo
                $newPhoto->setGroupe(MediaGroupe::photo);
                // firstMedia = false car ce n'est pas la bannière
                $newPhoto->setFirstMedia(0);
                // attribution du figure id
                $newPhoto->setFigure($figure);

                $entityManager->persist($newPhoto);
                $entityManager->flush();
            }
        }

        // création du formulaire de modification de la bannière
        $banner = new Media();
        $bannerForm = $this->createForm(MediaFormType::class, $banner);
        $bannerForm->handleRequest($request);
        $bannerPath = $bannerForm->get('media_path')->getData();

        //  Envoie du formulaire de bannière
        if ($bannerForm->isSubmitted() && $bannerForm->isValid()) {
            $newBanner = $bannerForm->getData();
            if ($bannerPath) {
                //suppression de l'ancienne bannière
                if ($figure->getBanner()) {
                    unlink($figure->getBanner()->getMediaPath());
                    $entityManager->remove($figure->getBanner());
                }
                $newFileName = uniqid() . '.' . $bannerPath->guessExtension();
                try {
                    $bannerPath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/tricksBanner/',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newBanner->setMediaPath('uploads/tricksBanner/' . $newFileName);
                //  la bannière est forcément une photo
                $newBanner->setGroupe(MediaGroupe::photo);
                // firstMedia = true car c'est la bannière
                $newBanner->setFirstMedia(1);
                // attribution du figure id
                $newBanner->setFigure($figure);

                $entityManager->persist($newBanner);
                $entityManager->flush();
            }
        }

        return $this->render('figure/edit_figure.html.twig', [
            'figure' => $figure,
            'medias' => $figure->getMedia(),
            'figureForm' => $figureForm->createView(),
            'bannerForm' => $bannerForm->createView(),
            'photoForm' => $photoForm->createView(),
            'videoForm' => $videoForm->createView()
        ]);
    }

    /**
     * Extrait une chaîne par rapport à une autre chaîne de début et de fin
     *
     * @param string $string chaîne de caractère dans laquelel on recherche 
     * @param string $start chaîne de caractère cherché dans $string pour trouver la position de départ
     * @param string $end chaîne de caractère cherché dans $string pour trouver la position de fin
     * @return string chaîne qui se trouve entre $start et $end ou chaîne vide si rien ne match
     */
    function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
