<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Entity\Demandedesponsoring;
use App\Entity\Evenement;
use App\Entity\Sponsor;
use App\Form\DemandedesponsoringType;
use App\Form\PropertySearchType;
use App\Repository\DemandedesponsoringRepositoy;
use App\Repository\EvenementRepository;
use App\Repository\SponsorRepositoy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
    
    /////////////////////////////////////////////////////////////////////////////// ADMIN /////////////////////////////////////////////////////////////////////
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
  *  
  * @Route("/accepterDemande/{id}", name="accepterDemande")
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
       return $this->redirectToRoute("listerD_idev",
       ['id'=>$event->getIdev()]);
   }
   elseif($progret_actuel+$pq> 100){
       $dm->refusing($id);
       return $this->redirectToRoute("listerD_idev",
       ['id'=>$event->getIdev()]);
    }
}



    /**
  *  
  * @Route("/refuserDemande/{id}", name="refuserDemande")
  */
  public function refuser_demande(Request $request , $id , DemandedesponsoringRepositoy $dm , EvenementRepository $eve) {
    $demande=$this->getDoctrine()->getRepository(Demandedesponsoring :: class)->findOneBy(['iddemande'=>$id]);
    $event=$demande->getIdev();
       $dm->refusing($id);
       return $this->redirectToRoute("listerD_idev",
       ['id'=>$event->getIdev()]);
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

   
    ////////////////////////////////////////////////////////////////////////////// SPONS /////////////////////////////////////////////////////////////////////
/**
 * @Route ("/mesdemandes" , name = "mesdemandes")
 */
public function affiche_des_demandes_par_spons ( DemandedesponsoringRepositoy $repo , Request $request){
    $spons = $this->getDoctrine()->getRepository(Sponsor::class)->findBy(['idsp'=>12]);
    $mesdemandes=$repo->findBy(['idsp'=>$spons]);
    
    $salles=$this->get('knp_paginator')->paginate(
        $mesdemandes, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        5 /*limit per page*/ 
    );
    $salles->setCustomParameters([
        'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
         # small|large (for template: twitter_bootstrap_v4_pagination)
        'style' => 'bottom',
        'span_class' => 'whatever',
    ]);

   //dd($mesdemandes);
    return $this->render("demandedesponsoring/afspons.html.twig",['demande'=>$salles]);
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////// CODENAME ONE ////////////////////////////////////////////////////////////////

    
    /////////////////////////////////////////////////////////////////////////////// ADMIN JSON /////////////////////////////////////////////////////////////////////
    /**
     * @Route("/afficherdemandesring/adminJSON/{id}", name="afficherDemandeSpingJSON")
     */
    public function affiche_demande_par_id_event_pr_admin_JSON($id, NormalizerInterface $nrm){
        $repo = $this->getDoctrine()->getRepository(Demandedesponsoring :: class);
        $repo1 = $this->getDoctrine()->getRepository(Evenement :: class)->findOneBy(['idev'=>$id]);

        $demande=$repo->findBy(['idev'=>$repo1]);
        $jsonContent = $nrm->normalize($demande,'json',['groups'=>'demande']);
        return new Response(json_encode($jsonContent));
    }
    /**
  *  
  * @Route("/accepterDemande/adminJSON/{id}", name="accepterDemandeJSON")
  */ 
  public function accepter_demande_adminJSON(Request $request , $id , DemandedesponsoringRepositoy $dm , EvenementRepository $eve , NormalizerInterface $nrm) {
    $em = $this->getDoctrine()->getManager();
    $demande=$this->getDoctrine()->getRepository(Demandedesponsoring :: class)->findOneBy(['iddemande'=>$id]);
    $event=$demande->getIdev();
    
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
   }
   elseif($progret_actuel+$pq> 100){
       $dm->refusing($id);
    }
    $jsonContent = $nrm->normalize($demande,'json',['groups'=>'demande']);
    return new Response(json_encode($jsonContent));
}



    /**
  *  
  * @Route("/refuserDemande/adminJSON/{id}", name="refuserDemandeJSON")
  */
  public function refuser_demande_adminJSON($id , DemandedesponsoringRepositoy $dm , NormalizerInterface $nrm) {
    $demande=$this->getDoctrine()->getRepository(Demandedesponsoring :: class)->findOneBy(['iddemande'=>$id]);
    $event=$demande->getIdev();
       $dm->refusing($id);
    $jsonContent=$nrm->normalize($demande,'json',['groups'=>'demande']);
    return new Response(json_encode($jsonContent));
    }

     /**
 * @Route("/supprimerDemande/adminJSON/{id}",name="supprimerDJSON")
 */

  public function supprimer_demande_adminJSON(NormalizerInterface $nrm, $id){
    $demande = $this->getDoctrine()->getRepository(Demandedesponsoring::class)->find($id);
    
    $entityManager=$this->getDoctrine()->getManager();
   $entityManager->remove($demande);
   $entityManager->flush();
   $jsonContent = $nrm->normalize($demande,'json',['groups'=>'demande']);
   return new Response(json_encode($jsonContent));
}

   
    ////////////////////////////////////////////////////////////////////////////// SPONS /////////////////////////////////////////////////////////////////////
/**
 * @Route ("/mesdemandes/sponJSON/{id}" , name = "mesdemandesJSON")
 */
public function affiche_des_demandes_par_spons_JSON( DemandedesponsoringRepositoy $repo ,NormalizerInterface $nrm , $id){
    $spons = $this->getDoctrine()->getRepository(Sponsor::class)->findBy(['idsp'=>$id]);
    $demande=$repo->findBy(['idsp'=>$spons]);
    $jsonContent = $nrm->normalize($demande,'json',['groups'=>'demande']);
        return new Response(json_encode($jsonContent));
}
         /**
     * @Route("/ajouterDemande/sponsJSON/{idsp}/{num}/new", name="envoyerDJSON")
     */
    public function ajouterDemandeSponsJSON (Request $req ,$idsp, $num ,NormalizerInterface $nrm) : Response{
        
        $spons =$this->getDoctrine()->getRepository(Sponsor::class)->findOneBy(['idsp'=>$idsp]);
        $eve =$this->getDoctrine()->getRepository(Evenement::class)->findOneBy(['idev'=>$num]);
        $demande= new Demandedesponsoring();
        
        $demande->setIdsp($spons);
        $demande->setIdev($eve);
        $demande->setDescription($req->get('description'));
        $demande->setPaquet($req->get('paquet'));
        
            $em=$this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
        $jsonContent = $nrm->normalize($demande , 'json' , ['groups'=>'demande']);
        return new Response(json_encode($jsonContent));    
    }
    /**
  *  
  * @Route("/modifierDemande/sponsJSON/{id}", name="modiferDJSON")
  */ 
  public function modifierdemandeSponsringJSON(Request $req , $id,NormalizerInterface $nrm) {
    $demande = new Demandedesponsoring();
    $demande= $this->getDoctrine()->getRepository(Demandedesponsoring::class)->find($id);
    
    $demande->setDescription($req->get('description'));
    $demande->setPaquet($req->get('paquet'));
         $entityManager = $this->getDoctrine()->getManager(); 
         $entityManager->flush();
    
    $jsonContent = $nrm->normalize($demande ,'json',['groups'=>'demande']);
    return new Response(json_encode($jsonContent));
    } 
}



