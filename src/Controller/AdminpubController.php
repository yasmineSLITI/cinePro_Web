<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publication;
use App\Entity\Presse;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;

use App\Repository\PublicationRepository;
use Dompdf\Dompdf;
use Dompdf\Options;

class AdminpubController extends AbstractController
{
    /**
     * @Route("/publication", name="publicationAdmin")
     */
    public function publication(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Publication::class)->findAll();
         
        $pub = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('adminPub/publication.html.twig', [
            
            'publications'=> $pub,
        ]);
    }
     /**
     * @Route("/publication/{id}", name="detail")
     */
    public function detail($id): Response
    {
        $detail = $this->getDoctrine()->getRepository(Publication::class)->find($id);
         
       
        return $this->render('adminPub/detail.html.twig', [
            
            'details'=> $detail,
           

        ]);
    }
    /**
     * @Route("/publication/supprimer/{id}", name="supprimerPubAdmin")
     */
    public function Supprimer($id,PublicationRepository $repo, FlashyNotifier $flashy){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $pub =$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($pub);
        $em->flush();
        $flashy->info('la publication est supprimée ');

        //$this->addFlash('message','Film Supprimé avec succés');
        return $this->redirectToRoute('publicationAdmin');
    }

    /**
     * @Route("/pdf", name="pubpdf")
     */
    public function pubpdf(): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $pub = $this->getDoctrine()->getRepository(Publication::class)->findAll();

       

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('adminpub/pubpdf.html.twig', [
            
            'pub'=> $pub,
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

      
}
