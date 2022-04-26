<?php

namespace App\Controller;

use App\Entity\Compte;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/front")
 */
class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function index(): Response
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}
