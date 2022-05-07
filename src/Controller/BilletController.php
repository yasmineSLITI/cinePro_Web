<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use App\Entity\Film;
use App\Entity\Billet;
use App\Form\BilletType;
use App\Services\QrcodeService;
use BaconQrCode\Encoder\QrCode;
use App\Repository\FilmRepository;
use App\Repository\BilletRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BilletController extends AbstractController
{
    /**
     * @Route("/billet/{idFilm}", name="app_billet")
     */
    public function index(Request $request, FilmRepository $filmRepo, $idFilm, QrcodeService $qrcodeService, BilletRepository $billetRepo, ClientRepository $clientRepo): Response
    {
        $billet = new Billet();
        $film = new Film();
        $qrCode = null;
        $film = $filmRepo->find($idFilm);
        $prixFinale = 0;

        $form = $this->createForm(BilletType::class, $billet);
        $form->handleRequest($request);


        if (($form->isSubmitted()) && ($form->isValid())) {

            $qrCode = $qrcodeService->qrcode('symfony');

            $calegorie = $request->get('billet')['categoriebillet'];
            $nbPlace = $request->get('billet')['nbPlace'];
            $billet->setCategoriebillet($calegorie);
            $billet->setNbPlace($nbPlace);
            $billet->setArchived(false);
            $billet->setIdreservation($idFilm);
            $billet->setIdclient(1);
            $billet->setCreatedOn(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($billet);
            $em->flush();

            if ($billet->getCategoriebillet() == "First Class") {
                $prixBillet = 50;
            } else if ($billet->getCategoriebillet() == "Second Class") {
                $prixBillet = 30;
            } else if ($billet->getCategoriebillet() == "Third Class") {
                $prixBillet = 10;
            }

            $prixFinale = $prixBillet * $billet->getNbPlace();
            $remise = null;

            //calcul remise
            $billets = $billetRepo->findAll();
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
            $client = $clientRepo->find($billet->getIdClient());
            $dateNaissance = $client->getDatenaiss();
            $dayNaissance = (int)$dateNaissance->format("d");
            $monthNaissance = (int)$dateNaissance->format("n");


            $createdOn = $billet->getCreatedOn();
            $day_CreatedOn = (int)$createdOn->format("d");
            $month_CreatedOn = (int)$createdOn->format("n");

            if (($dayNaissance == $day_CreatedOn) && ($monthNaissance == $month_CreatedOn)) {
                $remise += 0.3;
            }

            $prixFinaleApresRemise = $prixFinale - $remise * $prixFinale;


            return $this->render("billet/movieTicket.html.twig", [
                'billet' => $billet,
                'film' => $film,
                'qrcode' => $qrCode,
                'prixFinale' => $prixFinale,
                'prixFinaleApresRemise' => $prixFinaleApresRemise
            ]);
        } else {


            return $this->render("billet/index.html.twig", [
                'billetForm' => $form->createView(),
                'film' => $film,
            ]);
        }
    }

    /**
     * @route("Billet/supprimer/{id}", name="supprimerBillet")
     */


    public function supprimerBillet($id, BilletRepository $repo)
    {
        $billet = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($billet);
        $em->flush();
        return $this->render("listeFilm.html.twig");
    }

    /**
     * @route("billet/visualiser/{id}", name="visualiserBillet")
     */


    public function visualiserBillet($id, BilletRepository $repoBillet, FilmRepository $filmRepo, ClientRepository $clientRepo, QrcodeService $qrcodeService, BilletRepository $billetRepo)
    {
        $billet = $repoBillet->find($id);
        $film = $filmRepo->find($billet->getIdreservation());
        $client = $clientRepo->find($billet->getIdClient());
        $qrCode = $qrcodeService->qrcode('symfony');
        if ($billet->getCategoriebillet() == "First Class") {
            $prixBillet = 50;
        } else if ($billet->getCategoriebillet() == "Second Class") {
            $prixBillet = 30;
        } else if ($billet->getCategoriebillet() == "Third Class") {
            $prixBillet = 10;
        }

        $prixFinale = $prixBillet * $billet->getNbPlace();
        $remise = null;

        //calcul remise
        $billets = $billetRepo->findAll();
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
        $prixFinaleApresRemise = $prixFinale - $remise * $prixFinale;


        return $this->render(
            "/billet/cinemaTicket.html.twig",
            [
                'billet' => $billet,
                'film' => $film,
                'client' => $client,
                'qrcode' => $qrCode,
                'prixFinaleApresRemise' => $prixFinaleApresRemise
            ]
        );
    }
}
