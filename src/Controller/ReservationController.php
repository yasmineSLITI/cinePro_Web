<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Salle;
use App\Entity\Film;
use App\Entity\Evenement;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="app_reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
    /**
     * @param ReservationRepository $repo
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/AfficheRes", name="app_Res")
     */
    public function Affiche1(ReservationRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $data = $repo->findAll();
        $reservation = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render(
            'reservation/Affiche.html.twig',
            ['reservation' => $reservation]
        );
    }
    /**
     * @Route("/SupprimerRes/{id}", name="r")
     */
    public function Supprimer($id, ReservationRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $reservation = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $s = $reservation->getIdsa();
        $s->setDisponible("Disponible");
        $em->remove($reservation);
        $em->flush();
        //$this->addFlash('message','Film Supprimé avec succés');
        return $this->redirectToRoute('app_Res');
    }
    /**
     * @Route("reservation/Ajouter", name="")
     */
    public function add(Request $request)
    {
        $reservation = new reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $s = $reservation->getIdsa();
        if ($form->isSubmitted() && $form->isValid()) {
            if ($s->getDisponible() == "Disponible") {
                if ($s->getEnmaintenance() == false) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($reservation);
                    $s->setDisponible("Réservé");
                    $em->flush();
                    $em->flush($s);
                    return $this->redirectToRoute('app_Res');
                }
            }
        }
        return $this->render('reservation/Ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @param Request $request
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("reservation/Modifier/{id}", name="updateRes")
     */
    public function Update(ReservationRepository $repo, $id, Request $request)
    {
        $reservation = $repo->find($id);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('app_Res');
        }
        return $this->render('reservation/Modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @param ReservationRepository $repo
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/AfficheRes/json", name="app_Resjson")
     */
    public function Affichejson()
    {
        $repo = $this->getDoctrine()->getRepository(Film::class);
        $reservation = $repo->findAll();
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Reservation s ');
        $reservation = $qb->getArrayResult();
        $response = new Response(json_encode($reservation));
        return $response;
    }



    /**
     * @Route("reservation/Ajouter/json", name="")
     */
    public function addjson(Request $request, NormalizerInterface $Normalizer)
    {
        $reservation = new reservation();


        $em = $this->getDoctrine()->getManager();
        $reservation->setCategorie($request->get('categorie'));

        $reservation->setIdev($this->getDoctrine()->getRepository(Evenement::class)->find($request->get('idev')));
        $reservation->setIdf($this->getDoctrine()->getRepository(Film::class)->find($request->get("idf")));
        $reservation->setNbplace($request->get('nbplace'));
        $reservation->setDatedeb($request->get('datedeb'));
        $reservation->setDatefin($request->get('datefin'));
        $reservation->setIdsa($this->getDoctrine()->getRepository(Salle::class)->find($request->get('idsa')));


        $em->persist($reservation);
        $em->flush();
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Reservation s where s.idres = :v1')->setParameter('v1', $reservation->getIdres());
        $reservation = $qb->getArrayResult();
        $response = new Response(json_encode($reservation));
        return $response;
    }
}
