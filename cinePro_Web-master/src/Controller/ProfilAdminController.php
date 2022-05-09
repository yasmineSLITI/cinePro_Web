<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
* @Route("/profil")
*/

class ProfilAdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_profil_admin")
     */
    public function index(): Response
    {
        return $this->render('profil_admin/admin.html.twig', [
            'controller_name' => 'ProfilAdminController',
        ]);
    }
}
