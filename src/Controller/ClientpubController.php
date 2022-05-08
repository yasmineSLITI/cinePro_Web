<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PublicationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;


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
    public function publication(Request $request, PaginatorInterface $paginator, PublicationRepository $publicationRepo): Response
    {
        $donnees = $publicationRepo->findByArch();
        $p = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('clientPub/listePubClient.html.twig', [

            'publications' => $p,
        ]);
    }

    /**
     * @Route("/clientarchive", name="publicationArchive")
     */
    public function publicationArchive(Request $request, PaginatorInterface $paginator, PublicationRepository $publicationRepo): Response
    {
        $donnees = $publicationRepo->findByArchive();
        $pub = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('clientPub/pubarchive.html.twig', [

            'pub' => $pub,
        ]);
    }





    /**
     * @Route("/details/{id}", name="detailC")
     */
    public function detail($id): Response
    {
        $detail = $this->getDoctrine()->getRepository(Publication::class)->find($id);


        return $this->render('clientpub/detailclient.html.twig', [

            'details' => $detail,


        ]);
    }
}
