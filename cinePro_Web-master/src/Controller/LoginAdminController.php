<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginAdminController extends AbstractController
{
    

     /**
     * @Route("/admin/login", name="app_login1")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
       
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login_admin/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        
    }

    /**
     * @Route("/logout/admin", name="app_logout1")
     */
    public function logout(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $this->redirectToRoute("app_login1");
    }
}
