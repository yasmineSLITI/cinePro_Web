<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\Followingproduit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FollowingproduitController extends AbstractController
{
    /**
     * @Route("/followingproduit", name="app_followingproduit")
     */
    public function index(): Response
    {
        return $this->render('followingproduit/index.html.twig', [
            'controller_name' => 'FollowingproduitController',
        ]);
    }

    /**
     * @Route("/produit/AddToWishList/{idProduit}/{idClient}",name="addToWishList")
     */

    public function add($idProduit, $idClient)
    {
        $FP = new Followingproduit();
        $em = $this->getDoctrine()->getManager();

        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

        $client = $this->getDoctrine()->getRepository(Client::class)->find($idClient);


        $FP->setProduit($produit)
            ->setClient($client);
        $em->persist($FP);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => "Produit followé"
        ]);
    }

    /**
     * @route("/produit/removeFromWishList/{idProduit}/{idClient}", name="removeFromWishList")
     */

    public function delete($idProduit, $idClient)
    {

        $repo = $this->getDoctrine()->getRepository(Followingproduit::class);
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);
        $client = $this->getDoctrine()->getRepository(Client::class)->find($idClient);
        $FP = $repo->findOneBy(array('produit' => $produit, 'client' => $client));

        $em = $this->getDoctrine()->getManager();
        $em->remove($FP);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => "Produit removed"
        ]);
    }
}
