<?php

namespace App\Controller;
use App\Entity\Film;
use App\Repository\FilmRepository;
use App\Entity\Realisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class ArchiveController extends AbstractController
{
    /**
     * @Route("/archive", name="app_archive")
     */
    public function index(FilmRepository $repo,PaginatorInterface $paginator ,Request $request): Response
    {$data =$repo->findBy(['archive'=>true],['datedispo'=>'desc']);
        

        $film=$paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            3
        );
        //bonjour
        return $this->render('archive/archive.html.twig',
    ['film'=>$film]);
    
    }
}
