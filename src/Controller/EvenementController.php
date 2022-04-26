<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Realisateur;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\RealisateurRepository;
use App\Repository\SponsorRepositoy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class EvenementController extends Controller
{

    /**
     * @Route("/evenement", name="listerEv")
     */
    public function affiche(EvenementRepository $rep, Request $request) : Response{
        $ev = $rep->findAll();
        $event=$this->get('knp_paginator')->paginate(
            $ev, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        $event->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
             # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);
        return $this->render("evenement/afficherEvenement.html.twig",
        ['eve'=>$event]); 
    }
    /**
     * @Route("/evenement/{id}", name="listerEvRea")
     */
    public function affiche_par_realisateur(EvenementRepository $rep, Request $request,$id) : Response{
        $ev = $rep->findBy(['numrea'=>$id]);
        $event=$this->get('knp_paginator')->paginate(
            $ev, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            1 /*limit per page*/
        );
        return $this->render("evenement/afficherEvenement.html.twig",
        ['eve'=>$event]); 
    }

    /**
     * @Route("/evenementspons", name="sponsAffiche")
     */
    public function affiche_pour_spons(EvenementRepository $rep , Request $request) : Response{
        $ev = $rep->findAll(['etat'=>'Accepté']);
        $event=$this->get('knp_paginator')->paginate(
            $ev, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render("evenement/listeEvenementSpons.html.twig",
        ['eve'=>$event]); 
    }
    
    /**
     * @Route("/mesdemandesrea/{id}", name="reaAffiche")
     */
    public function affiche_pour_réalisateur(EvenementRepository $rep , $id , SponsorRepositoy $reps) : Response{
        $rea = $reps->findBy($id) ;
        $ev = $rep->findBy(['numrea'=>$rea]);
        return $this->render("evenement/listeEvenementRea.html.twig",
        ['eve'=>$ev, 'id'=>$id]);
    }

    /**
     * @Route("/detailevenement/{id}", name="detailE")
     */
    public function affiche_details(EvenementRepository $rep,$id) : Response{
        $ev = $rep->find($id);
        return $this->render("evenement/detailEvenement.html.twig",
        ['eve'=>$ev]); 

    }

    /**
     * @Route("/ajouterEvenement/{id}",name="ajouterE_id")
     */
   public function ajouter_pour_realisateur_par_id(Request $req, $id ,Request $reqq) : Response{
        $ev= new Evenement();
        $rea=new Realisateur();
        $rea =  $this->getDoctrine()->getRepository(Realisateur:: class)->findOneBy(['numrea'=>$id]);
        
        $form = $this->createForm(EvenementType::class,$ev);
        $ev->setNumrea($rea);
        $form->handleRequest($req);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $em=$this->getDoctrine()->getManager();
            $em->persist($ev);
            $em->flush();
           // dd($ev);
           return $this->redirectToRoute("reaAffiche",
                ['eve'=>$ev] , $id);
        }
        return $this->render('evenement/ajouterEvenementRealisateur.html.twig',[
            'form'=>$form->createView(),

        ]);
    }


    ////////////////////////////////////////////////// ICI //////////////////////////////////
    /**
     * @Route("/mesdemandesevents", name="affiche")
     */
    public function affiche_a_réalisateur( Request $request) : Response{
        $rea = $this->getDoctrine()->getRepository(Realisateur::class)->findOneBy(['numrea'=>1]) ;
        $ev = $this->getDoctrine()->getRepository(Evenement::class)->findBy(['numrea'=>$rea]);
        //  dd($ev);
        $event=$this->get('knp_paginator')->paginate(
            $ev, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        $event->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
             # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);
        
        return $this->render("evenement/listeEvenementRea.html.twig",
        ['eve'=>$event]);
    }
    /**
     * @Route("/ajouterEvenements",name="ajouterEvent")
     */
   public function ajouter_pour_realisateur_id(Request $req) : Response{
        $ev= new Evenement();
        $rea=new Realisateur();
        $rea =  $this->getDoctrine()->getRepository(Realisateur:: class)->findOneBy(['numrea'=>1]);
        
        $form = $this->createForm(EvenementType::class,$ev);
        $ev->setNumrea($rea);
        $form->handleRequest($req);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $em=$this->getDoctrine()->getManager();
            $em->persist($ev);
            $em->flush();
           // dd($ev);
           return $this->redirectToRoute("affiche",
                ['eve'=>$ev]);
        }
        return $this->render('evenement/ajouterEvenementRealisateur.html.twig',[
            'form'=>$form->createView(),

        ]);
    }
    
    /**
  *  
  * @Route("/modifierEvent/{id}", name="editer")
  * Method({"GET", "POST"})
  */ 
  public function modifier(Request $request , $id)  {
    $event= $this->getDoctrine()->getRepository(Evenement::class)->findOneBy(['idev'=>$id]);
    $form = $this->createForm(EvenementType::class,$event);
    $form->add('Enregistrer', SubmitType :: class);
    $form->add('Annuler', ResetType :: class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) 
    {
         $event = $form->getData();
         $entityManager = $this->getDoctrine()->getManager(); 
         $entityManager->flush();
         return $this->redirectToRoute('affiche'); 
     } 
     return $this->render('evenement/editDemandeDEvent.html.twig',['form'=> $form->createView()]);
  }
    ////////////////////////////////////// admin /////////////////////////
    /**
  *  
  * @Route("/accepterE/{id}", name="accepterE")
  * Method({"GET", "POST"})
  */ 
  public function accepter(Request $request , $id, EvenementRepository $rep)  {
    
         $query = $rep->accept($id);
         
         return $this->redirectToRoute('listerEv'); 
     
  } 
/**
  *  
  * @Route("/refuserE/{id}", name="refuserE")
  * Method({"GET", "POST"})
  */ 
  public function refuser( $id , EvenementRepository $rep )  {
    
    $query = $rep->supprimer($id);
    return $this->redirectToRoute('listerEv'); 
     
  }

  /**
 * @Route("/supprimerEvenement/{id}",name="supprimerE")
 * Method({"DELETE"})
 */

  /*public function supprimer(Request $request, $id){
     $ev = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
     $entityManager=$this->getDoctrine()->getManager();
    $entityManager->remove($ev);
    $entityManager->flush();
    $response=new Response();
    $response->send();
    return $this->redirectToRoute('listerEv');
}*/
}   

