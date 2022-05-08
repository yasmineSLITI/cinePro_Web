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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EvenementController extends Controller
{
///////////////////////////////////////////////////////////////////// admin /////////////////////////////////////////////////
    /**
     * @Route("/evenement", name="listerEv")
     */
    public function afficheEventdmin(EvenementRepository $rep, Request $request) : Response{
        $ev = $rep->findAll();
        $event=$this->get('knp_paginator')->paginate(
            $ev, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
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
     * @Route("/detailevenement/{id}", name="detailE")
     */
    public function affiche_details(EvenementRepository $rep,$id) : Response{
        $ev = $rep->find($id);
        return $this->render("evenement/detailEvenement.html.twig",
        ['eve'=>$ev]); 

    }

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

    
    ///////////////////////////////////////////////////////////////////////////////  spons  ///////////////////////////////////////////////////

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
        $event->setCustomParameters([
            'align' => 'center',
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);
        return $this->render("evenement/listeEvenementSpons.html.twig",
        ['eve'=>$event]); 
    }
    //////////////////////////////////////////////////////////////////// realisateur  /////////////////////////////////////////////////////////////////
    /**
     * @Route("/mesdemandesrea/{id}", name="reaAffiche")
     */
    public function affiche_pour_réalisateur(EvenementRepository $rep , $id ,request $request) : Response{
        $rea = $this->getDoctrine()->getRepository(Realisateur :: class)->findOneBy(['numrea'=>$id]) ;
        $idd = $rea->getNumrea();
        $ev = $rep->findBy(['numrea'=>$idd]);
        $event=$this->get('knp_paginator')->paginate(
            $ev, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        $event->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
             # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);
        
        return $this->render("evenement/listeEvenementRea.html.twig",
        ['eve'=>$event]);}

    /**
     * @Route("/ajouterEvenement/{id}",name="ajouterE_id")
     */
   public function ajouter_event_par_realisateur_par_id(Request $req, $id ,Request $reqq) : Response{
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
    /**
     * @Route("/mesdemandeseventsrea", name="affiche")
     */
    public function afficher_demande_a_réalisateur_stat( Request $request) : Response{
        $rea = $this->getDoctrine()->getRepository(Realisateur::class)->findOneBy(['numrea'=>1]) ;
        $ev = $this->getDoctrine()->getRepository(Evenement::class)->findBy(['numrea'=>$rea]);
        //  dd($ev);
        $event=$this->get('knp_paginator')->paginate(
            $ev, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
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




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////// CODENAME ONE //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////// admin ////////////////////////////////////////////////

    /**
     * @Route("/afficherEventJSON", name="afficherJSON")
     */
    public function afficherEventPrAdminJSON(NormalizerInterface $nrm) : Response{
        $repo = $this->getDoctrine()->getRepository(Evenement :: class);
        $event = $repo->findAll();
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Evenement s');
        $event = $qb->getArrayResult();
        $response = new Response(json_encode($event));
        return $response;
    }

/**
  *  
  * @Route("/accepterevenementJSON/{id}", name="accepterJSON")
  */ 
  public function accepterEventAdminJSON(Request $request , $id,NormalizerInterface $nrm)  {
   $em=$this->getDoctrine()->getManager();
   $event = $em->getRepository(Evenement :: class)->find($id);
   if($event->getEtat()=="En attente"){
   $event->setEtat("Accepté");
   $em->flush();}
   $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Evenement s where s.idev = :v1')->setParameter('v1',$event->getIdev());;
        $event = $qb->getArrayResult();
        $response = new Response(json_encode($event));
        return $response;

} 
/**
*  
* @Route("/refuserevenementJSON/{id}", name="refuserJSON")
*/ 
public function refuserJSON(Request $request , $id,NormalizerInterface $nrm)  {
    $em=$this->getDoctrine()->getManager();
    $event = $em->getRepository(Evenement :: class)->find($id);
    if($event->getEtat()=="En attente"){
    $event->setEtat("Refusé");
    $em->flush();}
    $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Evenement s where s.idev = :v1')->setParameter('v1',$event->getIdev());
        $event = $qb->getArrayResult();
        $response = new Response(json_encode($event));
        return $response;

}
    ///////////////////////////////////////////////////////////////////////////////  spons  ///////////////////////////////////////////////////

    /**
     * @Route("/afficherevent/sponsJSON", name="afficherprSpnsJSON")
     */
    public function afficheEventPrSponsJSON(Request $request , NormalizerInterface $nrm) : Response{
        $repo = $this->getDoctrine()->getRepository(Evenement :: class);
        $event = $repo->findBy(['etat'=>'Accepté']);
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Evenement s where s.etat = :v1')->setParameter('v1',"Accepté");
        $event = $qb->getArrayResult();
        $response = new Response(json_encode($event));
        return $response; 
    }
    //////////////////////////////////////////////////////////////////// realisateur  /////////////////////////////////////////////////////////////////
  
/**
     * @Route("/afficherevent/reaJSON/{id}", name="afficherprReaJSON")
     */
    public function afficheEventPrReaJSON(NormalizerInterface $nrm , $id) : Response{
        $repo = $this->getDoctrine()->getRepository(Evenement :: class);
        $event = $repo->findBy(['numrea'=>$id]);
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Evenement s where s.numrea = :v1')->setParameter('v1',$id);
        $event = $qb->getArrayResult();
        $response = new Response(json_encode($event));
        return $response;
        }

    /**
     * @Route("/demanderEvent/reaJSON/{id}/new",name="demanderEventReaJSON")
     */
   public function ajouterdemandeEventJSON(NormalizerInterface $nrm, $id ,Request $req) : Response{
    $em=$this->getDoctrine()->getManager();
    $event = new Evenement();
    $event->setNumrea($this->getDoctrine()->getRepository(Realisateur ::class)->find($id));
    $event->setMontant($req->get('montant'));
    $event->setDuree($req->get('duree'));
    $event->setNomev($req->get('nomev'));
    $event->setDescription($req->get('description'));
    $em->persist($event);
    $em->flush();
    $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Evenement s where s.idev = :v1')->setParameter('v1',$event->getIdev());
        $event = $qb->getArrayResult();
        $response = new Response(json_encode($event));
        return $response;
}
    


}   

