<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {

        $rep=$this->getDoctrine()->getRepository(User::class);

        $coachs =$rep-> findAll();
        return $this->render('produit/index.html.twig', [
            'coachs' => $coachs,
        ]);
    }
     /**
     * @Route("/listProduit", name="Listproduit")
     */
    public function list(): Response
    {
        return $this->render('produit/list.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
}
