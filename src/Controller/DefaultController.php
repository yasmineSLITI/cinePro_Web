<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
class DefaultController extends AbstractController
{
       /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {

        $rep=$this->getDoctrine()->getRepository(User::class);

        $coachs =$rep-> findAll();
        return $this->render('default/accueil.html.twig', [
            'coachs' => $coachs,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    
}
