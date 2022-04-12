<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Realisateur;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    
    /**
     * @param FilmRepository $repo
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/AfficheC", name="yosr")
     */
    public function Affiche(FilmRepository $repo){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $film =$repo->findAll();
        return $this->render('film/AfficheClient.html.twig',
    ['film'=>$film]);
    }
}
