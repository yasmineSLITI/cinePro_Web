<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PublicationRepository;
use App\Entity\Publication;
use App\Entity\Presse;

class ClientpubController extends AbstractController
{
    /**
     * @Route("/clientpub", name="app_clientpub")
     */
    public function index(): Response
    {
        return $this->render('baseFrontOffice.html.twig', [
            'controller_name' => 'ClientpubController',
        ]);
    }
/**
     * @Route("/client1", name="publicationClient")
     */
    public function publication(): Response
    {
        $p = $this->getDoctrine()->getRepository(Publication::class)->findAll();
         
        
        return $this->render('clientPub/listePubClient.html.twig', [
            
            'publications'=> $p,
        ]);
    }
    /**
     * @Route("/{id}", name="detailC")
     */
    public function detail($id): Response
    {
        $detail = $this->getDoctrine()->getRepository(Publication::class)->find($id);
         
       
        return $this->render('clientpub/detailclient.html.twig', [
            
            'details'=> $detail,
           

        ]);
    }
}
