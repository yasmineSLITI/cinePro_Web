<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Repository\PanierRepository;
use App\Entity\Produit;
use App\Entity\Client;
use App\Repository\ProduitRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
class SouvernirsController extends AbstractController
{
    /**
     * @Route("/souvernirs", name="app_souvernirs")
     */
    public function index(): Response
    {
        return $this->render('souvernirs/index.html.twig', [
            'controller_name' => 'SouvernirsController',
        ]);
    }
    /**
     * @Route("/Produits", name="Produits")
     */
    public function Produits()
    {
        return $this->render('souvernirs/index.html.twig', [
            'controller_name' => 'SouvernirsController',
        ]);
    }
     /**
     * @Route("/listProduit", name="listProduit")
     */
    public function listProduit()
    {
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('souvernirs/index.html.twig', ["produits" =>$produits]);
    }

    
    /**
     * @Route("/addPanier/{id}", name="addPanier")
     */
    public function addPanier($id)
    {   $idprd = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $panier = new Panier();
        $client = new Client();
        $panier->setNompanier("Disponible") ;
        $panier->setStatuspanier(0) ;
        $panier->setQuantite(1) ;
        $panier->setIdproduit($idprd) ;
        $panier-> setIdclient(1) ;
        $panier->setIdbillet(0) ;
    
      
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($panier);
            $em->flush();
            $this->addFlash('success', 'Votre Produit a été ajouté au panier avec succés!');
            return $this->redirectToRoute("listProduit");
        
        
    }

    /**
     * @Route("/ajouterPan/{id}", name="ajouetrPan")
     */
    public function ajouterPan(Request $request , NormalizerInterface $Normalizer,$id)
    {   $idprd = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $panier = new Panier();
        $client = new Client();
        $panier->setNompanier("Disponible") ;
        $panier->setStatuspanier(0) ;
        $panier->setQuantite(1) ;
        $panier->setIdproduit($idprd) ;
        $panier-> setIdclient(1) ;
        $panier->setIdbillet(0) ;
    
      
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($panier);
            $em->flush();
            $jsonContent = $Normalizer->normalize($panier,'json',['groups'=>'post:read']);
            return new Response (json_encode($jsonContent));
             
        
        
    }

   
}
