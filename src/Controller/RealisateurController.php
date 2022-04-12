<?php

namespace App\Controller;
use App\Entity\Film;
use App\Entity\Realisateur;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RealisateurController extends AbstractController
{
    /**
     * @Route("/realisateur", name="app_realisateur")
     */
    public function index(): Response
    {
        return $this->render('RealisateurBackOffice.html.twig', [
            'controller_name' => 'RealisateurController',
        ]);
    }
    /**
     * @param FilmRepository $repo
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/realisateur/AfficheF", name="app_film")
     */
    public function Affiche(FilmRepository $repo){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $film =$repo->findAll();
        return $this->render('realisateur/Affiche.html.twig',
    ['film'=>$film]);
    }
     /**
     * @Route("/realisateur/Supprimer/{id}", name="suppression")
     */
    public function Supprimer($id,FilmRepository $repo){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $film =$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($film);
        $em->flush();
        //$this->addFlash('message','Film Supprimé avec succés');
        return $this->redirectToRoute('app_film');
    }
  
     
     /**
     * @Route("/realisateur/Detaill/{id}", name="detail")
     */
    public function detail($id): Response
    {
        $detail = $this->getDoctrine()->getRepository(film::class)->find($id);
         
       
        return $this->render('realisateur/details.html.twig', [
            
            'details'=> $detail,
           

        ]);
    }
    
    /**
     * @param Request $request
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/realisateur/Modifier/{id}", name="m")
     */
    public function Update(FilmRepository $repo,$id,Request $request){
        $film=$repo->find($id);
        $form=$this->createForm(FilmType::class,$film);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            
            $em=$this->getDoctrine()->getManager();
            
            $em->flush();
            return $this->redirectToRoute('app_film');
        }
        return $this->render('realisateur/Modifier.html.twig',[
            'form'=>$form->createView()
        ]);
    }
     
}
