<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     *  @param ProjetRepository $repository
     * @return Response
     */


    /*private $em;



    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }*/



    public function index(ProjetRepository $repository): Response

    {
        $Projets = $repository->findAll();

        return $this->render('admin/index.html.twig',[
            'controller_name' => 'AdminController',
            'Projets' => $Projets,
        ]);
    }

    /**
     * @Route("/admin/projet/ajouter", name="admin.projet.ajouter")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function nouveau(Request $request, EntityManagerInterface $manager){
        $projet = new Projet();
        $Form = $this->createForm(ProjetType::class, $projet);
        $Form->handleRequest($request);


        if ($Form->isSubmitted() && $Form->isValid()){
            $manager->persist($projet);
            $manager->flush($projet);
            $this->addFlash('success', 'Le projet a bien été ajouté !');

            return $this->redirectToRoute("admin");

        }

        return $this->render('admin/projet/ajouter.html.twig', [
            'controller_name' => 'AjoutController',
            'Projets' => $projet,
            'Form' => $Form->createView()
        ]);




    }




    /**
     * @Route("/admin/{id}", name="admin.projet.editer", methods="GET|POST")
     * @param Projet $projet
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     *
     */
    public function editer(Projet $projet, Request $request, EntityManagerInterface $manager){
        $Form = $this->createForm(ProjetType::class, $projet);
        $Form->handleRequest($request);


        if ($Form->isSubmitted() && $Form->isValid()){

            $manager->flush($projet);
            $this->addFlash('success', 'Le projet a bien été modifié !');

            return $this->redirectToRoute("admin");
        }


        return $this->render('admin/projet/editer.html.twig', [
            'controller_name' => 'EditerController',
            'Projets' => $projet,
            'Form' => $Form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.projet.supprimer", methods="DELETE")
     * @param Projet $projet
     * @param EntityManagerInterface $manager
     * @return Response
     */

    public function supprimer(Projet $projet , EntityManagerInterface $manager){
        $manager->remove($projet);
        $manager->flush($projet);
        $this->addFlash('success', 'Le projet a bien été supprimé!');

        /*return new Response('Projet supprimé avec succés !');*/
        return $this->redirectToRoute("admin");



    }


}
