<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Realisateur;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\RealisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{

    /**
     * @Route("/evenement", name="listerEv")
     */
    public function affiche(EvenementRepository $rep) : Response{
        $ev = $rep->findAll();
        return $this->render("evenement/afficherEvenement.html.twig",
        ['eve'=>$ev]); 
    }

    /**
     * @Route("/evenementspons", name="sponsAffiche")
     */
    public function affiche_pour_spons(EvenementRepository $rep) : Response{
        $ev = $rep->findBy(['etat'=>'Accepté']);
        return $this->render("evenement/listeEvenementSpons.html.twig",
        ['eve'=>$ev]); 
    }

    /**
     * @Route("/evenement/{id}", name="detailE")
     */
    public function affiche_details(EvenementRepository $rep,$id) : Response{
        $ev = $rep->find($id);
        return $this->render("evenement/detailEvenement.html.twig",
        ['eve'=>$ev]); 
    }

    /**
     * @Route("/ajouterEvenement/{id}",name="ajouterE_id")
     */
   public function ajouter_pour_realisateur_par_id(Request $req, $idrea) : Response{
        $ev= new Evenement();
        $form = $this->createForm(EvenementType::class,$ev);
        $rea = $this->getDoctrine()->getRepository(RealisateurRepository :: class)->find($idrea);
        $ev->setNumrea($rea);
        $form->handleRequest($req);
        
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($ev);
            $em->flush();
            return $this->redirectToRoute("listerEv");
        }
        return $this->render('evenement/ajouterEvenementRealisateur.html.twig',[
            'form'=>$form->createView(),

        ]);
    }
     
    /**
     * @Route("/ajouterEvenement",name="ajouterE")
     */
   public function ajouter_pour_realisateur(Request $req) : Response{
    $ev= new Evenement();
    $form = $this->createForm(EvenementType::class, $ev);
    
    $form->handleRequest($req);
    
    if($form->isSubmitted() && $form->isValid()){
        $em=$this->getDoctrine()->getManager();
        $em->persist($ev);
        $em->flush();
        return $this->redirectToRoute("listerEv");
    }
    return $this->render('evenement/ajouterEvenementRealisateur.html.twig',[
        'form'=>$form->createView(),
    ]);
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

  /**
 * @Route("/supprimerEvenement/{id}",name="supprimerE")
 * Method({"DELETE"})
 */

  public function supprimer(Request $request, $id){
     $ev = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
     $entityManager=$this->getDoctrine()->getManager();
    $entityManager->remove($ev);
    $entityManager->flush();
    $response=new Response();
    $response->send();
    return $this->redirectToRoute('listerEv');
}
}

