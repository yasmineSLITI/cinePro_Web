<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SponssorController extends AbstractController
{
    /**
     * @Route("/sponssor", name="app_sponssor")
     */
    public function index(): Response
    {
        return $this->render('sponssor/index.html.twig', [
            'controller_name' => 'SponssorController',
        ]);
    }
}
