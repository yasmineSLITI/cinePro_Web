<?php

namespace App\Controller;


use App\Entity\Facture;
use App\Entity\Panier;
use App\Repository\FactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AdresseType;
use App\Entity\Adresse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\RechercheType;
use App\Data\SearchData;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;
//salma ; 

class FactureController extends AbstractController
{
    /**
     * @Route("/facture", name="app_facture")
     */
    public function index(): Response
    {
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }
    /**
     * @Route("/Tri", name="Tri")
     */
    public function Tri(Request $request, PaginatorInterface $paginator)
    {
       
        
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $formSearch = $this->createForm(RechercheType::class, $data);
        $formSearch->handleRequest($request);
        $facture = $this->getDoctrine()->getRepository(Facture::class)->orderByTotal($data);
        //$facture =$this->getDoctrine()->getRepository(Facture::class)->findSearch($data);
        return $this->render('facture/list.html.twig', ["facture" => $facture,'formSearch' => $formSearch->createView()]);
    }
     /**
     * @Route("/listFacture", name="listFacture")
     */
    public function listFacture(Request $request, PaginatorInterface $paginator)
    {  
      
        $facture = $this->getDoctrine()->getRepository(Facture::class)->findAll();
        
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $formSearch = $this->createForm(RechercheType::class, $data);
        $formSearch->handleRequest($request);
        $facture =$this->getDoctrine()->getRepository(Facture::class)->findSearch($data);
        return $this->render('facture/list.html.twig', ["facture" => $facture,'formSearch' => $formSearch->createView()]);
     
    }
     /**
     * @Route("/deleteF/{id}", name="deleteF")
     */
    public function deleteF($id)
    {
        $facture = $this->getDoctrine()->getRepository(Facture::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($facture);
        $em->flush();
        return $this->redirectToRoute("listFacture");
    }
    /**
     * @Route("/livrer", name="livrer")
     */
    public function livrer(Request $request,MailerInterface $mailer)
    {    $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class , $adresse);
        $form-> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()-> getManager();
            $em->persist($adresse);
            $em -> flush();
            $email = (new Email())
            ->from('JCC@example.com')
            ->to('salma.saadaoui@esprit.tn')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Confirmer livraison ')
            ->text('Sending emails is fun again!')
            ->html($this->renderView(
                // templates/emails/registration.html.twig
                'facture/Test.html.twig',
                
            ),
            'text/html');

        $mailer->send($email);
            return $this->render('facture/livraisonEmail.html.twig');
           


        }else {
            return $this->render('facture/livraison.html.twig',['Ff' => $form->createView()]);
        }
    }
     /**
     * @Route("/imprimer", name="imprimer")
     */
    public function imprimer()
    {  
       
        $listec = $this->getDoctrine()->getRepository(Facture::class)->findAll();
        return $this->render('facture/impression.html.twig', ["ff" => $listec
        ]);
     
    }
     /**
     * @Route("/pdf", name="pdf")
     */
    public function pdf()
    {  
       
        $listec = $this->getDoctrine()->getRepository(Facture::class)->findAll();
       
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('facture/impression.html.twig', [
            'title' => "Welcome to our PDF Test","ff" => $listec
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
     
    }
    /**
     * @Route("/viderFacture", name="viderFacture")
     */
    public function viderFacture()
    {  
       
        $listesup=$this ->getDoctrine()->
        getRepository(Facture::class)
        ->viderFacture();
        
        return $this->redirectToRoute("listFacture");
     
    }


     /**
     * @Route("/AllFacture", name="AllFacture")
     */
    public function AllFacture(NormalizerInterface $Normalizer )
    {  
      
        $facture = $this->getDoctrine()->getRepository(Facture::class)->findAll();
        
        $jsonContent = $Normalizer->normalize($facture,'json',['groups'=>'post:read']);
        return new Response (json_encode($jsonContent));
         
     
    }
}
