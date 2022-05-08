<?php

namespace App\Controller;

use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publication;
use App\Entity\Signale;
use App\Entity\Client;
use App\Repository\PublicationRepository;
use App\Repository\ClientRepository;
use App\Repository\SignalRepository;


use App\Repository\SignaleRepository;

class SignalpubController extends AbstractController
{
    /**
     * @Route("/signalpub/{idp}", name="app_signalpub")
     */
    public function ajout($idp, SignalRepository $SignaleRepo): Response
    {
        $signal = new Signale();

        $signal->setIdpub($this->getDoctrine()->getRepository(Publication::class)->find($idp));
        $signal->setIdclient($this->getDoctrine()->getRepository(Client::class)->find(4));

        $somme = $SignaleRepo->sumSig();
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($signal);
        $entityManager->flush();

        foreach ($somme as $sum) {


            if ($sum >= 4) {

                $som = $SignaleRepo->findOneBySomeField();
            }
        }

        return $this->redirectToRoute('publicationClient');
    }
    /*hhhhhhh*/
}
