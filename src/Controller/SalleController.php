<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Entity\Salle;
use App\Form\PropertySearchType;
use App\Form\SalleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SalleRepository;
use DateTime;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeImmutableToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SalleController extends Controller
{

///////////////////////////////////////////////////////// Calendrier ///////////////////////////////////////////////////

     /**
     * @Route("/cd_sa", name="calendrier")
     */
    public function index(SalleRepository $salles): Response
    {
        $salle_en_maintenance = $salles->findBy(['enmaintenance'=>true]);
        //$salle_en_maintenance = $salles->findBy(['disponible'=>"Non diponible"]);
        //dd($salle_en_maintenance);
        $maintenance= [];
        foreach($salle_en_maintenance as $s){
            $maintenance[]=[
                'title'=>$s->getNomsalle(),
                'start'=>$s->getDatedemaintenance()->format('Y-m-d'),
                'end'=>date("d-m-Y",strtotime($s->getDatedemaintenance()->format('Y-m-d'))+(604800*2)),
                
                ];
               // dd($maintenance);
                
        }
      
        $data = json_encode($maintenance);
        //dd($data);
        return $this->render('salle/index.html.twig', compact('data'));
    }
        
    
    /////////////////////////////////////////////////////// CRUD salle pour admin ////////////////////////////////////////////////



    /**
     * @Route("/salles", name="listeS")
     */
    public function affiche(Request $request , SalleRepository $repo) : Response{
       // $salle = $rep->findAll();
        $ps=new PropertySearch();
        $form =$this->createForm(PropertySearchType::class,$ps);
        $form->handleRequest($request);
       $recherche =[];
        $recherche=$this->getDoctrine()->getRepository(Salle::class)->findAll();
        $recherche1=$this->getDoctrine()->getRepository(Salle::class)->findAll();
        foreach($recherche as $s){
            $mois_sys = date('m');
            $mois_salle = date('m',strtotime($s->getDatedemaintenance()->format('d-m-Y')));
            $x=$mois_sys-$mois_salle;
            $y=$s->getDatedemaintenance();
            
           if(strtotime("now")-strtotime($y->format('d-m-Y'))>=(86400*183)){
            $s->setEnmaintenance(true);
            //$s->setDatedemaintenance(new DateTime("now"));
            $s->setDisponible('Non disponible');
            $this->getDoctrine()->getManager()->flush();
           }
            
            
        }
//        $recherche=$this->getDoctrine()->getRepository(Salle::class)->findOneBy(['idsa' => 6]);
     if($form->isSubmitted()&&$form->isValid()){
            $nom=$ps->getNom();
            if ($nom!="")
            $recherche=$this->getDoctrine()->getRepository(Salle::class)->findBy(['nomsalle'=>$nom]);
            
            }
            
        $salles=$this->get('knp_paginator')->paginate(
            $recherche,
            $request->query->getInt('page', 1),
            5
        );
        $salles->setCustomParameters([
            'align' => 'center',
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);
        
        return $this->render("salle/afficherSalle.html.twig",
        ['form' => $form->createView(),'salle'=>$salles]); 
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
         $entityManager->flush($salle);
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

/**
 * @Route("/maintenir/{id}",name ="maintenir")
 */
public function maitenir($id , SalleRepository $rep){
    $s=$rep->find($id);
    $s->setEnmaintenance(false);
    $s->setDatedemaintenance(new DateTime("now"));
    $s->setDisponible('Disponible');
    $this->getDoctrine()->getManager()->flush();
    return $this->redirectToRoute('listeS');

}


/////////////////////////////////////////////////////////// Réservation YOSR ///////////////////////////////////////////////////
/**
 * @Route("/reserver/{id}",name ="reserver")
 */
public function reserver($id , SalleRepository $rep){
    $s=$rep->find($id);
    
    $s->setDisponible('Non disponible');
    $this->getDoctrine()->getManager()->flush();
    return $this->redirectToRoute('listeS');

}
/**
 * @Route("/liberer/{id}",name ="reserver")
 */
public function liberer($id , SalleRepository $rep){
    $s=$rep->find($id);
    
    $s->setDisponible('Disponible');
    $this->getDoctrine()->getManager()->flush();
    return $this->redirectToRoute('listeS');

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////// CODENAME ONE //////////////////////////////////////////////////////////////////////////



/**
     * @Route("/salleJSON", name="affichageJSON")
     */
    public function afficheJSON(NormalizerInterface $ner) :Response {
        $repo = $this->getDoctrine()->getRepository(Salle :: class);
        $salle = $repo->findAll();
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Salle s');
        $salle = $qb->getArrayResult();
        $response = new Response(json_encode($salle));
        return $response;
     }
 
     /**
      * @Route("/ajouterSalleJSON/new",name="ajoutJSON")
      */
    public function ajouterJSON(Request $req , NormalizerInterface $nrm) : Response{
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle();
        $salle->setNomsalle($req->get('nomsalle'));
        $salle->setCapacite($req->get('capacite'));
        $salle->setDatedemaintenance(new DateTime());
       $em->persist($salle);
        $em->flush();
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Salle s where s.idsa = :v1')->setParameter('v1',$salle->getIdsa());
        $salle = $qb->getArrayResult();
        $response = new Response(json_encode($salle));
        return $response;
     }
      /**
   *  
   * @Route("/reserverSalleJSON/{id}", name="reserverJSON")
   */ 
   public function reserverJSON(Request $req , NormalizerInterface $nrm,$id) {
       $em=$this->getDoctrine()->getManager();
       $salle=$em->getRepository(Salle :: class)->find($id);
       if($salle->getEnmaintenance()==false){
        if($salle->getDisponible()=="Disponible")
           $salle->setDisponible("Non disponible");
       }
       $em->flush();
       $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Salle s where s.idsa = :v1')->setParameter('v1',$salle->getIdsa());
        $salle = $qb->getArrayResult();
        $response = new Response(json_encode($salle));
        return $response;
   } 
      /**
   *  
   * @Route("/libererSalleJSON/{id}", name="libererJSON")
   */ 
   public function libererJSON(Request $req , NormalizerInterface $nrm,$id) {
    $em=$this->getDoctrine()->getManager();
    $salle=$em->getRepository(Salle :: class)->find($id);
    if($salle->getEnmaintenance()==false){
     if($salle->getDisponible()=="Non disponible")
        $salle->setDisponible("Disponible");}
    $em->flush();
    $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Salle s where s.idsa = :v1')->setParameter('v1',$salle->getIdsa());
        $salle = $qb->getArrayResult();
        $response = new Response(json_encode($salle));
        return $response;
   } 
      /**
   *  
   * @Route("/modifierSalleJSON/{id}", name="modiferJSON")
   */ 
   public function modifierJSON(Request $req , NormalizerInterface $nrm,$id) {
       $em=$this->getDoctrine()->getManager();
       $salle=$em->getRepository(Salle :: class)->find($id);
       $salle->setNomsalle($req->get('nomsalle'));
       $salle->setCapacite($req->get('capacite'));
       $salle->setEnmaintenance($req->get('enmaintenance'));
       $salle->setDatedemaintenance(new DateTime());
       if($salle->getEnmaintenance()==true){
           $salle->setDisponible("Non disponible");
       }
       else if($salle->getEnmaintenance()==false){
        $salle->setDisponible("Disponible");
       }
       $em->flush();
       $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Salle s where s.idsa = :v1')->setParameter('v1',$salle->getIdsa());
        $salle = $qb->getArrayResult();
        $response = new Response(json_encode($salle));
        return $response;
   } 
 
 
   /**
  * @Route("/supprimerSalleJSON/{id}",name="supprimerJSON")
  */
 
   public function supprimerJSON(Request $req,NormalizerInterface $nrm ,$id){
    $em=$this->getDoctrine()->getManager();
    $salle=$em->getRepository(Salle::class)->find($id);
    $em->remove($salle);
    $em->flush();
    $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Salle s where s.idsa = :v1')->setParameter('v1',$salle->getIdsa());
        $salle = $qb->getArrayResult();
        $response = new Response(json_encode($salle));
        return $response;
 }
 /**
  * @Route("/rechercherSalleJSON/{id}",name="rechercherJSON")
  */
  public function salleResearchJSON (Request $req ,NormalizerInterface $nrm , $id){
      $em=$this->getDoctrine()->getManager();
      $salle =$em->getRepository(Salle :: class)->findBy(['nomsalle'=>$id]);
      $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Salle s where s.nomsalle = :v1')->setParameter('v1',$id);
        $salle = $qb->getArrayResult();
        $response = new Response(json_encode($salle));
        return $response;
  }
}


