<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PublicationType;
use App\Entity\Publication;
use App\Entity\Presse;

use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\File\UploadFile;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Knp\Component\Pager\PaginatorInterface;

class PressepubController extends AbstractController
{
   /**
     * @Route("/presse", name="appPresse")
     */

    public function publication1(Request $request, PaginatorInterface $paginator): Response
    {
        $pub = $this->getDoctrine()->getRepository(Publication::class)->findAll();
        
        
        
        return $this->render('pressepub/index.html.twig', [
            
            'publications'=> $pub,
        ]);
    }
    /**
     * @Route("/presse/listepub", name="publicationPresse")
     */

    public function publication(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Publication::class)->findAll();
        $pub = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            2
        );
        
        return $this->render('pressepub/listepub.html.twig', [
            
            'publications'=> $pub,
        ]);
    }

    /**
     * @Route("/presse/ajouter/{id}", name="app_presse")
     */
    public function new(Request $request, $id): Response
    
    {

        $Publication = new Publication();
        

        $form = $this->createForm(PublicationType::class, $Publication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Publication->setIdpresse($this->getDoctrine()->getRepository(Presse::class)->find($id));
            $file =$form->get('imgpub')->getData();         
            $fileName = md5(uniqid()).'.'.$file->guessExtension(); 
         $file->move($this->getParameter('images_directory'), $fileName); 
         $Publication->setImgpub($fileName); 
        
          
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Publication);
            $entityManager->flush();
            $this->addFlash('Success','Created successfully');

            return $this->redirectToRoute('publicationPresse');
        }

        return $this->render('pressePub/ajouterPubPresse.html.twig', [
            'pub' => $Publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/presse/listepub/supprimer/{id}", name="supprimerPub")
     */
    public function Supprimer($id,PublicationRepository $repo){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $pub =$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($pub);
        $em->flush();
        //$this->addFlash('message','Film Supprimé avec succés');
        return $this->redirectToRoute('publicationPresse');
    }

}
