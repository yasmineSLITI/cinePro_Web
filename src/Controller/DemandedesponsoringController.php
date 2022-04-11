<?php

namespace App\Controller;

use App\Entity\Demandedesponsoring;
use App\Form\DemandedesponsoringType;
use App\Repository\DemandedesponsoringRepositoy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandedesponsoringController extends AbstractController
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
 * @Route ("/mesdemandes/{id}" , name = "mesdemandes")
 */
public function affiche_des_demandes_par_spons ($id , DemandedesponsoringRepositoy $repo){
    $mesdemandes=$repo->findBySponsId($id);
    return $this->render("demandedesponsoring/afficherDemandedesponsoringparspons.html.twig",
['mesdemande'=>$mesdemandes]);
}



    /**
     * @Route("/listeDemande", name="listerD")
     */
    public function affiche(DemandedesponsoringRepositoy $rep) : Response{
        $demande = $rep->findAll();
        return $this->render("demandedesponsoring/afficherDemandedesponsoring.html.twig",
        ['demande'=>$demande]); 
    }

    /**
     * @Route("/ajouterDemande",name="ajouterD")
     */
   public function ajouter(Request $req) : Response{
        $demande= new Demandedesponsoring();
        $form = $this->createForm(DemandedesponsoringType::class,$demande);
        
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute("listerD");
        }
        return $this->render('demandedesponsoring/ajouterDemandedesponsoring.html.twig',[
            'form'=>$form->createView(),
        ]);
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
    return$this->redirectToRoute('listerD');
}
}



