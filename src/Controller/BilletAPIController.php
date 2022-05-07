<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Billet;
use App\Entity\Client;
use App\Services\QrcodeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BilletAPIController extends AbstractController
{
    /**
     * @Route("/billet/addBillet", name="api_add_billet")
     */
    public function addBillet(NormalizerInterface $Normalizer, Request $request): Response
    {
        // dd($request);
        $billet = new Billet();

        $billet->setCategoriebillet($request->get('categoriebillet'));
        $billet->setNbPlace($request->get('nbPlace'));
        $billet->setArchived(false);
        $billet->setIdreservation($request->get('idReservation'));
        $billet->setIdclient($request->get('idReservation'));
        $billet->setCreatedOn(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($billet);
        $em->flush();

        $jsonContent  = $Normalizer->normalize($billet, 'json', ['groups' => 'api:billet']);

        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @route("billet/deleteBillet/{id}", name="api_delete_billet")
     */

    public function deleteBillet($id, NormalizerInterface $Normalizer)
    {
        $billet = $this->getDoctrine()->getRepository(Billet::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($billet);
        $em->flush();

        return new Response(
            "{\"response\": \"billet deleted.\"}",
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @route("billet/visualiserBillet/{id}", name="api_visulaiser_billet")
     */

    public function visualiserBilletMobile($id, QrcodeService $qrcodeService, NormalizerInterface $Normalizer)
    {
        $billet = $this->getDoctrine()->getRepository(Billet::class)->find($id);
        $film = $this->getDoctrine()->getRepository(Film::class)->find($billet->getIdreservation());
        $client = $this->getDoctrine()->getRepository(Client::class)->find($billet->getIdClient());


        //calcul prix inital d'un billet
        if ($billet->getCategoriebillet() == "First Class") {
            $prixBillet = 50;
        } else if ($billet->getCategoriebillet() == "Second Class") {
            $prixBillet = 30;
        } else if ($billet->getCategoriebillet() == "Third Class") {
            $prixBillet = 10;
        }

        $prixFinaleAvantRemise = $prixBillet * $billet->getNbPlace();
        $remise = null;

        //calcul remise
        $billets = $this->getDoctrine()->getRepository(Billet::class)->findAll();
        $em = $this->getDoctrine()->getManager();
        foreach ($billets as $billet) {
            $purchases = $em->getRepository(Billet::class)->findBy(array('idclient' => $billet->getIdclient(), 'categoriebillet' => 'First Class'));
        }

        $count = count($purchases);
        if (($count > 3) && ($count <= 5)) {
            $remise = 0.3;
        } else if (($count > 5) && ($count <= 10)) {
            $remise = 0.4;
        } else if ($count > 10) {
            $remise = 0.5;
        }
        $dateNaissance = $client->getDatenaiss();
        $dayNaissance = (int)$dateNaissance->format("d");
        $monthNaissance = (int)$dateNaissance->format("n");


        $createdOn = $billet->getCreatedOn();
        $day_CreatedOn = (int)$createdOn->format("d");
        $month_CreatedOn = (int)$createdOn->format("n");

        if (($dayNaissance == $day_CreatedOn) && ($monthNaissance == $month_CreatedOn)) {
            $remise += 0.3;
        }
        $prixFinaleApresRemise = $prixFinaleAvantRemise - $remise * $prixFinaleAvantRemise;

        $qrCode = $qrcodeService->qrcode('symfony');

        //Normalizing
        $jsonBillet = $Normalizer->normalize($billet, 'json', ['groups' => 'api:billet']);
        $jsonFilm = $Normalizer->normalize($film, 'json', ['groups' => 'films']);
        $jsonClient = $Normalizer->normalize($client, 'json', ['groups' => 'clients']);
        $jsonPrixFinaleAvantRemise = $Normalizer->normalize($prixFinaleAvantRemise, 'json');
        $jsonPrixFinaleApresRemise = $Normalizer->normalize($prixFinaleApresRemise, 'json');
        $jsonQRCode = $Normalizer->normalize($qrCode, 'json');

        return $this->json(
            [
                'billet' => $jsonBillet,
                'film' => $jsonFilm,
                'client' => $jsonClient,
                'prixFinaleAvantRemise' => $jsonPrixFinaleAvantRemise, 'prixFinaleApresRemise' => $jsonPrixFinaleApresRemise,
                'qrCode' => $jsonQRCode,
            ],
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @route("billet/prixInitialBillet/{NbPlace}/{categoriebillet}", name="api_prixInitialBillet_billet")
     */

    public function prixInitialBillet($NbPlace, $categoriebillet, NormalizerInterface $Normalizer)
    {
        //calcul prix inital d'un billet
        if ($categoriebillet == "First Class") {
            $prixBillet = 50;
        } else if ($categoriebillet == "Second Class") {
            $prixBillet = 30;
        } else if ($categoriebillet == "Third Class") {
            $prixBillet = 10;
        }

        $prixFinaleAvantRemise = $prixBillet * $NbPlace;

        $jsonContent  = $Normalizer->normalize($prixFinaleAvantRemise, 'json');

        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }


    /**
     * @route("billet/remise", name="api_remise_billet")
     */

    public function remise(NormalizerInterface $Normalizer)
    {
        $remise = 0;
        $client = $this->getDoctrine()->getRepository(Client::class)->find(1);
        $billets = $this->getDoctrine()->getRepository(Billet::class)->findAll();
        $em = $this->getDoctrine()->getManager();
        foreach ($billets as $billet) {
            $purchases = $em->getRepository(Billet::class)->findBy(array('idclient' => $billet->getIdclient(), 'categoriebillet' => 'First Class'));
        }

        $count = count($purchases);
        if (($count > 3) && ($count <= 5)) {
            $remise = 5;
        } else if (($count > 5) && ($count <= 10)) {
            $remise = 10;
        } else if ($count > 10) {
            $remise = 20;
        }
        $dateNaissance = $client->getDatenaiss();
        $dayNaissance = (int)$dateNaissance->format("d");
        $monthNaissance = (int)$dateNaissance->format("n");


        $createdOn = $billet->getCreatedOn();
        $day_CreatedOn = (int)$createdOn->format("d");
        $month_CreatedOn = (int)$createdOn->format("n");

        if (($dayNaissance == $day_CreatedOn) && ($monthNaissance == $month_CreatedOn)) {
            $remise += 30;
        }

        $jsonContent  = $Normalizer->normalize($remise, 'json');

        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }
}
