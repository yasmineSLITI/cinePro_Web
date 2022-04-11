<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SalleRepository;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SalleController extends AbstractController
{

    /**
     * @Route("/salles", name="listeS")
     */
    public function affiche(SalleRepository $rep) : Response{
        $salle = $rep->findAll();
        return $this->render("salle/afficherSalle.html.twig",
        ['salle'=>$salle]); 
    }

    /**
     * @Route("/ajouterSalle",name="ajouterS")
     */
   public function ajouter(Request $req) : Response{
        $salle= new Salle();
        $form = $this->createForm(SalleType::class,$salle);
        //$form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        $salle->setDisponible("Disponible");
        $salle->setEnmaintenance(false);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($salle);
            $em->flush();
            return $this->redirectToRoute("listeS");
        }
        return $this->render('salle/ajouterSalle.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
     /**
  *  
  * @Route("/modifierSalle/{id}", name="modiferS")
  * Method({"GET", "POST"})
  */ 
  public function modifier(Request $request , $id) {
    $salle= $this->getDoctrine()->getRepository(Salle::class)->find($id);
    $form = $this->createForm(SalleType::class,$salle);
    $form->add('enmaintenance');
    $form->add('Enregistrer', SubmitType :: class);
    $form->add('Annuler', ResetType :: class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) 
    {
         $salle = $form->getData();
         $entityManager = $this->getDoctrine()->getManager(); 
         $entityManager->flush();
         return $this->redirectToRoute('listeS'); 
     } 
     return $this->render('salle/modifierSalle.html.twig',['form'=> $form->createView()]);
  } 


  /**
 * @Route("/supprimerSalle/{id}",name="supprimerS")
 * Method({"DELETE"})
 */

  public function supprimer(Request $request, $id){
     $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
     $entityManager=$this->getDoctrine()->getManager();
    $entityManager->remove($salle);
    $entityManager->flush();
    $response=new Response();
    $response->send();
    return$this->redirectToRoute('listeS');
}
}
