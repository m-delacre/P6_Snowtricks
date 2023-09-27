<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Media;
use App\Entity\MediaGroupe;
use Doctrine\ORM\EntityManagerInterface;

class MediaController extends AbstractController
{
    #[Route('/media/delete/{id}', name: 'app_media_delete', methods: ['GET', 'DELETE'])]
    public function deleteMedia(Media $media, EntityManagerInterface $entityManager): Response
    {
        $figure = $media->getFigure();

        // Suppression de l'image
        if($media->getGroupe() == MediaGroupe::photo) {
            unlink($media->getMediaPath());
        }
       
        $entityManager->remove($media);
        $entityManager->flush();

        return $this->redirectToRoute('app_figure', ['slug' => $figure->getSlug()]);
    }
}
