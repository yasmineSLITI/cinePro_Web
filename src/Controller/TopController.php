<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Film;
use App\Entity\Avis;
use App\Repository\FilmRepository;
use App\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
class TopController extends AbstractController

{
    /**
     * @Route("/top", name="app_top")
     */
    public function index(): Response
    {
        return $this->render('top/index.html.twig', [
            'controller_name' => 'TopController',
        ]);
    }
    /**
     * @Route("/top/afficherTop", name="app")
     */
    public function Affiche(AvisRepository $repoA,FilmRepository $repo,PaginatorInterface $paginator ,Request $request){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        
       
           //$repo=$this->getDoctrine()->getRepository(Film::class);
        
       $avi=new Avis();
         

           $moy =$repoA->findAllmoy();
           //foreach ($moy as $key => $value) {
            
        
            //$avi->setMoyenneavis($repoA->uppdate($value));
           //}
        $film =$repo->findAllMoy();
       

        
        

            
              
    
                

            
        return $this->render('top/top.html.twig',
    ['film'=>$film,'moy'=>$moy]);

    }
}
