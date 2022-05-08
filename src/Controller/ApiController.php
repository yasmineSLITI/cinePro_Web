<?php

namespace App\Controller;

use App\Entity\Salle;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\RememberMe\ResponseListener;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/{id}/edit" , name ="api_event_edit" , methods={"PUT"})
     */
    public function majEvent (?Salle $salle , Request $req){
        //recuperation des données envoyées par fullcalendar
        $donnee = json_decode($req->getContent());

        if(
            isset($donnee->nomSalle) && !empty($donnee->nomSalle) &&
            isset($donnee->start) && !empty($donnee->start) &&
            isset($donnee->end) && !empty($donnee->end) &&
            isset($donnee->backgroundColor) && !empty($donnee->backgroundColor) &&
            isset($donnee->borderColor) && !empty($donnee->borderColor) &&
            isset($donnee->textColor)&&!empty($donnee->textColor) &&
            isset($donnee->allDay)&&!empty($donnee->allDay)&&
            isset($donnee->groupTd)&&!empty($donnee->groupTd)&&
            isset($donnee->interactive)&&!empty($donnee->interacive)&&
            isset($donnee->hasEnd)&&!empty($donnee->hasEnd)
            ){
                //données complètes
                //initialisation du code 200
                $code=200;

                //verifiant l'existance de l'id
                if(!$salle){
                    //instanciant une salle
                    $salle=new Salle();
                    $code =201; 
                }
                //on hydrate l'objet avec nos données
                $salle->setNomsalle($donnee->nomSalle);
                $salle->setDatedemaintenance(new DateTime($donnee->start));
                $salle->setEnmaintenance(true);
                dd($salle);
                $em=$this->getDoctrine()->getManager();
                $em->persist($salle);
                $em->flush();

                return new Response ('OK',$code);

        }else{
            //données manquantes
            return new Response('Données incomplètes' , 404);
        }
    }
}
