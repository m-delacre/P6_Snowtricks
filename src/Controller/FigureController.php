<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Entity\FigureGroupe;
use App\Form\FigureFormType;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FigureController extends AbstractController
{
    #[Route('/figure', name: 'app_figure')]
    public function index(): Response
    {
        return $this->render('figure/index.html.twig', [
            'controller_name' => 'FigureController',
        ]);
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

            //enregistrement des données
            $entityManager->persist($newFigure);
            $entityManager->flush();

            //redirection vers la home pages
            return $this->redirectToRoute('app_home');
        }

        return $this->render('figure/create.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
