<?php

namespace App\Controller;


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
        $signal->setIdclient($this->getDoctrine()->getRepository(Client::class)->find(1));

        $somme = $SignaleRepo->SommeSignal($idp);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($signal);
        $entityManager->flush();

        if ($somme > 4) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($this->getDoctrine()->getRepository(Publication::class)->find($idp));
            $em->flush();
        }

        return $this->redirectToRoute('publicationClient');
    }
    /*hhhhhhh*/
}
