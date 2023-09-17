<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Figure;
use App\Entity\Media;
use App\Form\FigureFormType;
use App\Form\MediaFormType;
use App\Repository\FigureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/figure/show/{name}', name: 'app_figure')]
    public function displayFigure(FigureRepository $figureRepository, Request $request):Response
    {
        $dataURL = $request->getPathInfo();    
        $name = substr($dataURL, strpos($dataURL, "show") + 5); 
        //dd($dataURL, $name);
        $figure = $figureRepository->findOneBy(['name' => $name]);
        return $this->render('figure/figure.html.twig', ['figure'=> $figure]);
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
            'form'=>$form->createView()
        ]);
    }

    #[Route('/figure/edit/{id}', name: 'app_figure_edit')]
    public function editFigure(Figure $figure, Request $request, EntityManagerInterface $entityManager, Media $media): Response
    {
        $figureForm = $this->createForm(FigureFormType::class, $figure);
        $figureForm->handleRequest($request);

        // TODO: faire choisir le type de media vidéo ou photo et donc faire différents formulaire en fonction du media
        // $mediaForm = $this->createForm(MediaFormType::class, $media);
        // $mediaForm->handleRequest($request);

        if ($figureForm->isSubmitted() && $figureForm->isValid()) {
            $figure->setUpdateDate(new DateTime());
            $entityManager->flush();
            return $this->redirectToRoute('app_figure', ['name'=> $figure->getName()]);
        }

        return $this->render('figure/edit_figure.html.twig', [
            'figure' => $figure,
            'figureForm' => $figureForm->createView(),
            //'mediaForm' => $mediaForm->createView()
        ]);
    }
}
