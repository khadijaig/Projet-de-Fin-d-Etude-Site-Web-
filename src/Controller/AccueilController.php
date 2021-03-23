<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     * @param ProjetRepository $repository
     * @return Response
     */
    public function index(ProjetRepository $repository): Response
    {
        $Projets = $repository->findLatest();

        return $this->render('accueil/index.html.twig', [
            'Projets' => $Projets,
            'controller_name' => 'AccueilController',
        ]);
    }
}
