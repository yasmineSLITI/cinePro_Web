<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
class DefaultController extends AbstractController
{
       /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {

        $rep=$this->getDoctrine()->getRepository(User::class);

        $coachs =$rep-> findAll();
        return $this->render('default/accueil.html.twig', [
            'coachs' => $coachs,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }


     /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $posts =  $em->getRepository('AppBundle:Post')->findEntitiesByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Post Not found :( ";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }


    
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getNom(),$posts->getPrenom()];

        }
        return $realEntities;
    }
}
