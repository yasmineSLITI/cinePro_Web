<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class AdminController extends AbstractController
{
   /**
     * @Route("/statistiqueAdmin", name="stats")
     * @IsGranted("ROLE_ADMIN")
     */
    public function statistiques(){
        // statistique 
        $users =$this->getDoctrine()->getRepository(User::class)->findAll();
        
        return $this->render('statAdmin/statistiqueAdmin.html.twig',[
          'users' => $users   
        ]);
    }
  
}
