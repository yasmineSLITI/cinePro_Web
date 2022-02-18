<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Repository\UserRepository;
use App\Repository\ClietnRepository;
use App\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
     /**
     * @Route("/listClient", name="listClient")
     */
    public function list(): Response
    {
        $rep=$this->getDoctrine()->getRepository(User::class);

        $clients =$rep-> findAll();

        return $this->render('client/list.html.twig', [
            'clients' => $clients,
        ]);
    }
     /**
     * @Route("/deleteClient/{id}", name="deleteClient")
     */
    public function delete($id)
    { $rep=$this->getDoctrine()->getRepository(User::class);
      $em=$this->getDoctrine()->getManager();
      $client=$rep->find($id);
      $em->remove($client);
      $em->flush();
        return $this->redirectToRoute('listClient');
       
    }
    
  
     /**
     * @Route("/ajouterClient", name="addClient")
     */
    public function ajouter(Request $request)
    {
        $client = new User();
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        
       
        if($form->isSubmitted()){
            $client-> setRole("client");
            $client = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            
            $em->flush();
            return $this->redirectToRoute('listClient');

        }
        return $this->render('client/add.html.twig', [
            'formA' => $form->createView()
        ]);
}
   

    /**
     * @Route("/modifierClient{id}", name="modifierClient")
     */
    public function modifier(Request $request, $id)
    {
        $rep=$this->getDoctrine()->getRepository(User::class);
        $client = $rep->find($id);
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listClient');

        }

        return $this->render('client/update.html.twig', [
            'formA' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/showClient{id}", name="showClient", methods={"GET"})
     */
    public function show(User $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }
}
