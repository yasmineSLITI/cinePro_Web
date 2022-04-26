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
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Date;

class SalleController extends Controller
{



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
        
    

    // calender
    //salle



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
            $diff=$y->diff(new DateTime());
            //$i=0;
            //echo($s->getNomsalle());
            //dd(date('m',strtotime($y->format('d-m-Y'))) =='01');
            
            //dd(86400*183);
           // echo(' * ');
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
            $recherche, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/ 
        );
        $salles->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
             # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);
        $time = new \DateTime();
        //$time=$time->format('d-m-Y');
        //dd($time);
        //echo $time->format('d-m-Y');
        /*$recherche1=$recherche1->getDatedemaintenance()->diff($time);
        $che1=$recherche1->getDatedemaintenance();
        $diff=date_diff($time ,$che1);
        $recherche1=$recherche1->format('d-m-Y');
        dd($diff);*/
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
         if($salle->getDisponible() == 'Disponible' && $salle->getEnmaintenance()==false){
         $entityManager = $this->getDoctrine()->getManager(); 
         $entityManager->flush();
         return $this->redirectToRoute('listeS'); }
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
/**
 * @Route("/reserver/{id}",name ="reserver")
 */
public function reserver($id , SalleRepository $rep){
    $s=$rep->find($id);
    
    $s->setDisponible('Non disponible');
    $this->getDoctrine()->getManager()->flush();
    return $this->redirectToRoute('listeS');

}
}
