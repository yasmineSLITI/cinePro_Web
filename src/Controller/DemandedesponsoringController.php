<?php

namespace App\Controller;

use App\Entity\Demandedesponsoring;
use App\Entity\Evenement;
use App\Entity\Sponsor;
use App\Form\DemandedesponsoringType;
use App\Repository\DemandedesponsoringRepositoy;
use App\Repository\EvenementRepository;
use App\Repository\SponsorRepositoy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DemandedesponsoringController extends Controller
{
    /**
     * @Route("/demandedesponsoring", name="app_demandedesponsoring")
     */
    public function index(): Response
    {
        return $this->render('demandedesponsoring/index.html.twig', [
            'controller_name' => 'DemandedesponsoringController',
        ]);
    }
    
   


/**
 * @Route ("/mesdemandes" , name = "mesdemandes")
 */
public function affiche_des_demandes_par_spons ( DemandedesponsoringRepositoy $repo){
    $spons = $this->getDoctrine()->getRepository(Sponsor::class)->findBy(['idsp'=>12]);
    $mesdemandes=$repo->findBy(['idsp'=>$spons]);
   //dd($mesdemandes);
    return $this->render("demandedesponsoring/afspons.html.twig",['demande'=>$mesdemandes]);
}

    /**
     * @Route("/listeDemande/{id}", name="listerD_idev")
     */
    public function affiche_demande_par_id_event($id, Request $request) : Response{
       //$demande = new Demandedesponsoring();

        $repp=$this->getDoctrine()->getRepository(Demandedesponsoring::class)->findby(['idev'=>$id]);
       //dd($repp);
       $demandes=$this->get('knp_paginator')->paginate(
        $repp, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        5 /*limit per page*/);

        return $this->render("demandedesponsoring/afficherDemandedesponsoring.html.twig",
        ['demande'=>$demandes]); 
        
      //  return $this->redirectToRoute("listerEv");
    }
 /**
     * @Route("/ajouterDemande/{num}", name="envoyerD")
     */
    public function envoyer_demande (Request $req , $num) : Response{
        
        $spons =new Sponsor();
        $eve =new Evenement();
        $demande= new Demandedesponsoring();
        
        $spons= $this->getDoctrine()->getRepository(Sponsor::class)->findOneBy(['idsp'=>12]);
        $eve= $this->getDoctrine()->getRepository(Evenement::class)->findOneBy(['idev'=>$num]);
       
       $form = $this->createForm(DemandedesponsoringType::class,$demande);
        
        $demande->setIdsp($spons);
        $demande->setIdev($eve);

        
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute("mesdemandes");
        }
        return $this->render('demandedesponsoring/ajouterdemande.html.twig',
        ['form'=>$form->createView(),]);
    }


    /**
  *  
  * @Route("/accepterDemande/{id}", name="accepterDemande")
  * Method({"GET", "POST"})
  */ 
  public function accepter_demande(Request $request , $id , DemandedesponsoringRepositoy $dm , EvenementRepository $eve) {
    $demande=$this->getDoctrine()->getRepository(Demandedesponsoring :: class)->findOneBy(['iddemande'=>$id]);
    $event=$demande->getIdev();
    $mnt = $event->getMontant();
    $pq=$demande->getPaquet();
    $progret_actuel=$event->getProgret();
    if($demande->getPaquet()=="Bronze"){
       $pq=20;
    }
    elseif($demande->getPaquet()=="Silver"){
       $pq=40;
    }
    elseif($demande->getPaquet()=="Gold"){
       $pq=80;
    }
   /*$prg = $mnt*$pq /100;
   $progret_actuel += $prg;*/
   if($progret_actuel+$pq <= 100){
       $progret_actuel=$progret_actuel+$pq;
       $demande->setEtataccept("Accepté");
       $dm->accepter($id);
       $eve->updateProgress($event->getIdev(),$progret_actuel);
       return $this->render("evenement/detailEvenement.html.twig",
       ['eve'=>$event]);
   }
   elseif($progret_actuel+$pq> 100){
       $dm->refusing($id);
       return $this->render("evenement/detailEvenement.html.twig",
       ['eve'=>$event]);
    }
}



    /**
  *  
  * @Route("/refuserDemande/{id}", name="refuserDemande")
  * Method({"GET", "POST"})
  */ 
  public function refuser_demande(Request $request , $id , DemandedesponsoringRepositoy $dm , EvenementRepository $eve) {
    $demande=$this->getDoctrine()->getRepository(Demandedesponsoring :: class)->findOneBy(['iddemande'=>$id]);
    $event=$demande->getIdev();
       $dm->refuser($id);
       return $this->redirectToRoute("evenement/detailEvenement.html.twig",
       ['eve'=>$event]);
    }
   
  
    
/**
  *  
  * @Route("/modifierDemande/{id}", name="modiferD")
  * Method({"GET", "POST"})
  */ 
  public function modifier(Request $request , $id) {
    $demande = new Demandedesponsoring();
    $demande= $this->getDoctrine()->getRepository(Demandedesponsoring::class)->find($id);
    $form = $this->createForm(DemandedesponsoringType::class,$demande);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) 
    {
         $salle = $form->getData();
         $entityManager = $this->getDoctrine()->getManager(); 
         $entityManager->flush();
         return $this->redirectToRoute('listerD'); 
     } 
     return $this->render('demandedesponsoring/afficherDemandedesponsoring',['form'=> $form->createView()]);
  } 



  /**
 * @Route("/supprimerDemande/{id}",name="supprimerD")
 * Method({"DELETE"})
 */

  public function supprimer(Request $request, $id){
     $demande = $this->getDoctrine()->getRepository(Demandedesponsoring::class)->find($id);
     
     $entityManager=$this->getDoctrine()->getManager();
    $entityManager->remove($demande);
    $entityManager->flush();
    $response=new Response();
    $response->send();
    return$this->redirectToRoute('listerD_idev');
}

}



