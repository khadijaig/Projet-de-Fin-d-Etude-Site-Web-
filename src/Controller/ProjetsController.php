<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetsController extends AbstractController

{


    /**
     * @var ProjetRepository
     */
    private $repository;


    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(ProjetRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;

    }


    /**
     * @Route("/projets", name="projets")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */



    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        /*$projet = $this->repository->findActive();*/
        $projet = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1),
            6);






        return $this->render('projets/index.html.twig', [
            'controller_name' => 'ProjetsController',
            'projets' => $projet
        ]);
    }

    /**
     * @Route("/projets/{slug}-{id}", name="Projet.afficher", requirements={"slug" : "[a-z0-9\-]*"})
     * @param Projet $projet
     * @return Response
     */
    public function afficher(Projet $projet, string $slug) : Response{
        if ($projet ->getSlug() !== $slug){
            return $this->redirectToRoute('Projet.afficher', [
                'id' => $projet->getId(),
                'slug' => $projet->getSlug()
            ], 301);
        }


        return $this->render('Projet/afficher.html.twig',
            ['controller_name' => 'Projets', 'Projet' => $projet]);
    }
}
