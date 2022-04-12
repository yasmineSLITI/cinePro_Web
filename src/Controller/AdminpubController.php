<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publication;
use App\Entity\Presse;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PublicationRepository;

class AdminpubController extends AbstractController
{
    /**
     * @Route("/publication", name="publicationAdmin")
     */
    public function publication(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Publication::class)->findAll();
         
        $pub = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('adminPub/publication.html.twig', [
            
            'publications'=> $pub,
        ]);
    }
     /**
     * @Route("/publication/{id}", name="detail")
     */
    public function detail($id): Response
    {
        $detail = $this->getDoctrine()->getRepository(Publication::class)->find($id);
         
       
        return $this->render('adminPub/detail.html.twig', [
            
            'details'=> $detail,
           

        ]);
    }
}
