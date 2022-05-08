<?php

namespace App\Controller;

use App\Repository\DemandedesponsoringRepositoy;
use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="app_stats")
     */
    public function index(): Response
    {
        return $this->render('stats/index.html.twig', [
            'controller_name' => 'StatsController',
        ]);
    }
    /**
 * @Route("/stat",name="stats")
 */
public function stat(DemandedesponsoringRepositoy $rep , SalleRepository $srep){
    $demandes =count( $rep->findAll());
    $demandes_accepted= count($rep->findBy(['etataccept'=>"Accepté"]));
    $demandes_rejected= count($rep->findBy(['etataccept'=>"En attente"]));
    $en_att= count($rep->findBy(['etataccept'=>"Refusé"]));
    
    $en_maintenance= count($srep->findBy(['enmaintenance'=>true]));
    $maintenue= count($srep->findBy(['enmaintenance'=>false]));
    
    $dispo= count($srep->findBy(['disponible'=>"Disponible"]));
    $reserve= count($srep->findBy(['disponible'=>"Non disponible"]));
    
    return $this->render('/stats.html.twig', [
        'waiting'=>json_encode($demandes_rejected) , 
        "accepted" =>json_encode($demandes_accepted),
        "rejected" =>json_encode($en_att), 
        "en"=>json_encode($en_maintenance),
        "main"=>json_encode($maintenue),
        "dispo"=>json_encode($dispo),
        "non"=>json_encode($reserve)
    ]);
}
}
