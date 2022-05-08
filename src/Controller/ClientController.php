<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Realisateur;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    
    /**
     
     * @Route("/AfficheC", name="yosr")
     */
    public function Affiche(FilmRepository $repo,PaginatorInterface $paginator ,Request $request){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $data =$repo->findBy(['archive'=>false],['datedispo'=>'desc']);
        

        $film=$paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            3
        );
        return $this->render('film/AfficheClient.html.twig',
    ['film'=>$film]);
    }
    
}
