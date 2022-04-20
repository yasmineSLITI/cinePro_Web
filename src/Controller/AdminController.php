<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\FollowingproduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    /**
     * @Route("/stats",name="stats")
     */

    public function statistiques(ProduitRepository $repo, FollowingproduitRepository $followRepo)
    {

        $produits = $repo->findAll();
        //les donnée pour la pie chart des produits en stock et epuisé
        $produitEnStock_Count = 0;
        $produitOutOfStock_Count = 0;

        foreach ($produits as $p) {

            if ($p->getQuantiteenstock() > 0) {
                $produitEnStock_Count++;
            } else {
                $produitOutOfStock_Count++;
            }
        }

        $prodDesignation = [];
        $followings = [];

        foreach ($produits as $p) {
            if ($p->getQuantiteenstock() == 0) {
                $prodDesignation[] = $p->getDesignation();
                $followings[] = $followRepo->count(['produit' => $p]);
            }
        }

        return $this->render('admin/stats2.html.twig', [
            'Produits' => $produits,
            'produitEnStock_Count' => json_encode($produitEnStock_Count),
            'produitOutOfStock_Count' => json_encode($produitOutOfStock_Count),
            'prodDesignation' => json_encode($prodDesignation),
            'followings' => json_encode($followings),
        ]);
    }
}
