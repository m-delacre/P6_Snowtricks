<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    #[Route('/api/comments/{figureName}/{offset}', name: 'app_comment_loadMore')]
    public function getTwoComments($figureName, $offset, CommentRepository $commentRepository, EntityManagerInterface $em, FigureRepository $figureRepository): JsonResponse
    {
        $figure = $figureRepository->findOneBy(['name'=>$figureName]);
        $comments = $commentRepository->loadMoreComments($figure, $offset, $em);
        return new JsonResponse($comments, Response::HTTP_OK, [], false);
    }
}
