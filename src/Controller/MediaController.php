<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Entity\Media;
use App\Entity\MediaGroupe;
use App\Entity\User;
use App\Form\MediaFormType;
use App\Form\VideoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends AbstractController
{
    #[Route('/media/delete/{id}', name: 'app_media_delete', methods: ['GET', 'DELETE'])]
    public function deleteMedia(Media $media, EntityManagerInterface $entityManager): Response
    {
        $figure = $media->getFigure();

        // Suppression de l'image
        if ($media->getGroupe() == MediaGroupe::photo) {
            unlink($media->getMediaPath());
        }

        $entityManager->remove($media);
        $entityManager->flush();

        return $this->redirectToRoute('app_figure_edit', ['id' => $figure->getId()]);
    }

    #[Route('/media/create/photo/{id}', name: 'app_media_create_photo')]
    public function createMediaPhoto(Figure $figure, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() == null) {
            return $this->render('other/connexionRequired.html.twig');
        }

        $canCreate = $this->userCanCreateMedia($this->getUser(), $figure);

        if ($canCreate == false) {
            return $this->render('other/cant_modify_figure.html.twig');
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

                return $this->redirectToRoute('app_figure_edit', ['id' => $figure->getId()]);
            }
        }

        return $this->render('media/ajout_media_photo.html.twig', [
            'photoForm' => $photoForm->createView(),
        ]);
    }

    #[Route('/media/create/video/{id}', name: 'app_media_create_video')]
    public function createMediaVideo(Figure $figure, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() == null) {
            return $this->render('other/connexionRequired.html.twig');
        }

        $canCreate = $this->userCanCreateMedia($this->getUser(), $figure);

        if ($canCreate == false) {
            return $this->render('other/cant_modify_figure.html.twig');
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
            $lien = substr($fullstring, 17);
            $newVideo->setMediaPath($lien);

            // Le groupe ici est photo
            $newVideo->setGroupe(MediaGroupe::video);

            // firstMedia = false car ce n'est pas la bannière
            $newVideo->setFirstMedia(0);

            // attribution du figure id
            $newVideo->setFigure($figure);

            $entityManager->persist($newVideo);
            $entityManager->flush();

            return $this->redirectToRoute('app_figure_edit', ['id' => $figure->getId()]);
        }

        return $this->render('media/ajout_media_video.html.twig', [
            'videoForm' => $videoForm->createView()
        ]);
    }

    #[Route('/media/manage/banner/{id}', name: 'app_media_manage_banner')]
    public function gestionBanner(Figure $figure, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() == null) {
            return $this->render('other/connexionRequired.html.twig');
        }

        $canCreate = $this->userCanCreateMedia($this->getUser(), $figure);

        if ($canCreate == false) {
            return $this->render('other/cant_modify_figure.html.twig');
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
                
                return $this->redirectToRoute('app_figure_edit', ['id' => $figure->getId()]);
            }
        }

        return $this->render('media/ajout_media_banner.html.twig', [
            'bannerForm' => $bannerForm->createView()
        ]);
    }

    #[Route('/media/update/video/{id}', name: 'app_media_update_video')]
    public function updateMediaVideo(Media $media, Request $request, EntityManagerInterface $entityManager): Response
    {
        $figure = $media->getFigure();

        // création du formulaire d'édition de la video
        $videoForm = $this->createForm(VideoFormType::class, $media);
        $videoForm->handleRequest($request);

        // Envoie du formulaire de la video
        if ($videoForm->isSubmitted() && $videoForm->isValid()) {
            $getLien = $videoForm->getData('media_path');
            $newLien = substr($getLien->getMediaPath(), 17);
            $media->setMediaPath($newLien);
            $entityManager->flush();
            return $this->redirectToRoute('app_figure_edit', ['id' => $figure->getId()]);
        }

        return $this->render('media/ajout_media_video.html.twig', [
            'videoForm' => $videoForm->createView()
        ]);
    }

    #[Route('/media/update/photo/{id}', name: 'app_media_update_photo')]
    public function updateMediaPhoto(Media $media, Request $request, EntityManagerInterface $entityManager): Response
    {
        $figure = $media->getFigure();

        // création du formulaire d'édition de la photo
        $photoForm = $this->createForm(MediaFormType::class, $media);
        $photoForm->handleRequest($request);
        $photoPath = $photoForm->get('media_path')->getData();

        if ($photoForm->isSubmitted() && $photoForm->isValid()) {
            if ($photoPath) {
                //suppression de l'ancienne photo sur le serveur
                if ($media->getMediaPath()) {
                    unlink($media->getMediaPath());
                }
                $newFileName = uniqid() . '.' . $photoPath->guessExtension();
                try {
                    $photoPath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/tricksPhoto/',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $media->setMediaPath('uploads/tricksPhoto/' . $newFileName);

                $entityManager->persist($media);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_figure_edit', ['id' => $figure->getId()]);
            }
        }

        return $this->render('media/ajout_media_photo.html.twig', [
            'photoForm' => $photoForm->createView(),
        ]);
    }

    /**
     * Vérifie si un utilisateur est apte à ajouter un média
     * Pour être apte il doit être connecté et être l'auteur de cette figure
     *
     * @param User|null $user l'utilisateur si il est connecté
     * @param Figure $figure la figure où l'utilisateur souhaite ajouter le media
     * @return boolean true il est authorisé, false il ne peut pas.
     */
    private function userCanCreateMedia(?User $user, Figure $figure): bool
    {
        if ($user == null) {
            return false;
        }

        if ($user == true) {
            if ($figure->getUserId() == $user) {
                return true;
            } else {
                return false;
            }
        }
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
