<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CoachType;
use App\Repository\CoachRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CoachController extends AbstractController
{
 /**
     * @Route("/coach", name="coach")
     */
    public function index(): Response
    {
        return $this->render('coach/index.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }
     /**
     * @Route("/listCoach", name="listCoach")
     */
    public function list(): Response
    {
        $rep=$this->getDoctrine()->getRepository(User::class);

        $coachs =$rep-> findAll();

        return $this->render('coach/list.html.twig', [
            'coachs' => $coachs,
        ]);
    }
     /**
     * @Route("/deleteCoach/{id}", name="deleteCoach")
     */
    public function delete($id)
    { $rep=$this->getDoctrine()->getRepository(User::class);
      $em=$this->getDoctrine()->getManager();
      $coach=$rep->find($id);
      $em->remove($coach);
      $em->flush();
        return $this->redirectToRoute('listCoach');
       
    }
    
  
     /**
     * @Route("/ajouterCoach", name="addCoach")
     */
    public function ajouter(Request $request)
    {
        $coach = new User();
        $form=$this->createForm(CoachType::class,$coach);
        $form->handleRequest($request);
        
       
        if($form->isSubmitted()){
            $coach-> setRole("coach");
            $coach = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($coach);
            $em->flush();
            return $this->redirectToRoute('listCoach');

        }
        return $this->render('coach/add.html.twig', [
            'formA' => $form->createView()
        ]);
}
   

    /**
     * @Route("/modifierCoach{id}", name="modifierCoach")
     */
    public function modifier(Request $request, $id)
    {
        $rep=$this->getDoctrine()->getRepository(User::class);
        $coach = $rep->find($id);
        $form=$this->createForm(CoachType::class,$coach);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listCoach');

        }

        return $this->render('coach/update.html.twig', [
            'formA' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/showCoach{id}", name="showCoach", methods={"GET"})
     */
    public function show(User $coach): Response
    {
        return $this->render('coach/show.html.twig', [
            'coach' => $coach,
        ]);
    }
}
