<?php

namespace App\Controller;

use App\Repository\BilletRepository;
use App\Repository\PanierRepository;
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

    public function statistiques(ProduitRepository $repo, FollowingproduitRepository $followRepo, BilletRepository $billetRepo, PanierRepository $repoPanier)
    {
        $count_firstClass = 0;
        $count_secondClass = 0;
        $count_thirdClass = 0;

        $billet_januaryCount = 0;
        $billet_febuaryCount = 0;
        $billet_marchCount = 0;
        $billet_aprilCount = 0;
        $billet_mayCount = 0;
        $billet_juneCount = 0;
        $billet_julyCount = 0;
        $billet_augustCount = 0;
        $billet_septemberCount = 0;
        $billet_octoberCount = 0;
        $billet_novemberCount = 0;
        $billet_decemberCount = 0;

        $billets = $billetRepo->findAll();
        foreach ($billets as $b) {
            if ($b->getCategoriebillet() == 'First Class') {
                $count_firstClass++;
            } else if ($b->getCategoriebillet() == 'Second Class') {
                $count_secondClass++;
            } else if ($b->getCategoriebillet() == 'Third Class') {
                $count_thirdClass++;
            }
        }


        foreach ($billets as $b) {
            $createdOn = $b->getCreatedOn();
            $day_CreatedOn = (int)$createdOn->format("n");
            if ($day_CreatedOn == 1) {
                $billet_januaryCount++;
            } elseif ($day_CreatedOn == 2) {
                $billet_febuaryCount++;
            } elseif ($day_CreatedOn == 3) {
                $billet_marchCount++;
            } elseif ($day_CreatedOn == 4) {
                $billet_aprilCount++;
            } elseif ($day_CreatedOn == 5) {
                $billet_mayCount++;
            } elseif ($day_CreatedOn == 6) {
                $billet_juneCount++;
            } elseif ($day_CreatedOn == 7) {
                $billet_julyCount++;
            } elseif ($day_CreatedOn == 8) {
                $billet_augustCount++;
            } elseif ($day_CreatedOn == 9) {
                $billet_septemberCount++;
            } elseif ($day_CreatedOn == 10) {
                $billet_octoberCount++;
            } elseif ($day_CreatedOn == 11) {
                $billet_novemberCount++;
            } elseif ($day_CreatedOn == 12) {
                $billet_decemberCount++;
            }
        }


        $produits = $repo->findAll();
        $paniers = $repoPanier->findAll();
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
        $quantiteVendu = [];

        $quantiteVendu[] = $repo->QuantiteVenduProduit(1);
        $designationProduitVendu[] = $repo->DesignationProduitVendu(1);

        foreach ($produits as $p) {
            if ($p->getQuantiteenstock() == 0) {
                $prodDesignation[] = $p->getDesignation();
                $followings[] = $followRepo->count(['produit' => $p]);
            }
        }
        $quantiteProdVendu = [];
        foreach ($quantiteVendu[0] as $q) {
            $quantiteProdVendu[] = $q[1];
        }
        $designationProdVendu = [];
        foreach ($designationProduitVendu[0] as $q) {
            $designationProdVendu[] = $q['designation'];
        }


        return $this->render('admin/stats2.html.twig', [
            'Produits' => $produits,
            'count_firstClass' => $count_firstClass,
            'count_SecondClass' => $count_secondClass,
            'count_thirdClass' => $count_thirdClass,
            'produitEnStock_Count' => json_encode($produitEnStock_Count),
            'produitOutOfStock_Count' => json_encode($produitOutOfStock_Count),
            'prodDesignation' => json_encode($prodDesignation),
            'followings' => json_encode($followings),
            'quantiteProdVendu' => json_encode($quantiteProdVendu),
            'designationProdVendu' => json_encode($designationProdVendu),
            'billet_januaryCount' => json_encode(
                $billet_januaryCount
            ),
            'billet_febuaryCount' => json_encode(
                $billet_febuaryCount
            ),
            'billet_marchCount' => json_encode(
                $billet_marchCount
            ),
            'billet_aprilCount' => json_encode(
                $billet_aprilCount
            ),
            'billet_mayCount' => json_encode(
                $billet_mayCount
            ),
            'billet_juneCount' => json_encode(
                $billet_juneCount
            ),
            'billet_julyCount' => json_encode(
                $billet_julyCount
            ),
            'billet_augustCount' => json_encode(
                $billet_augustCount
            ),
            'billet_septemberCount' => json_encode(
                $billet_septemberCount
            ),
            'billet_octoberCount' => json_encode(
                $billet_octoberCount
            ),
            'billet_novemberCount' => json_encode(
                $billet_novemberCount
            ),
            'billet_decemberCount' => json_encode(
                $billet_decemberCount
            )
        ]);
    }
}
