<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Data\CSVData;
use App\Form\CSVType;
use App\Entity\Client;
use App\Entity\Produit;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\ProduitType;
use App\Form\SearchProductType;
use App\Services\QrcodeService;
use App\Entity\Followingproduit;
use Symfony\Component\Mime\Email;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\FollowingproduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="affichage_Produits")
     */
    public function index(ProduitRepository $repo, Request $request, PaginatorInterface $paginator, QrcodeService $qrcodeService)
    {

        $qrCode = null;
        $qrCode = $qrcodeService->qrcode('symfony');

        //data = $form->getData()
        //$qrcodeService->qrcode($data['name'])
        $donnees = $repo->findAll();
        $Products = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render(
            'produit/back_office/index.html.twig',
            [
                'products' => $Products,
                'donnees' => $donnees,
                'qrcode' => $qrCode
            ]

        );
    }

    /**
     * @Route("/imprimer", name="impression_Produits")
     */
    public function imprimer(ProduitRepository $repo)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $Products = $repo->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView(
            'produit/back_office/list.html.twig',
            [
                'products' => $Products,
            ]
        );

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
     * @route("/produit/ajouter",name="ajouterProduit")
     */

    public function ajouterProduit(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid())) {
            $file = $request->files->get('produit')['image'];

            $uploads_directory = $this->getParameter('uploads_directory');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $fileName
            );

            $em = $this->getDoctrine()->getManager();
            $produit->setImage($fileName);

            $em->persist($produit);

            $em->flush();
            $this->addFlash('success', 'Produit ajouté avec succès');

            return $this->redirectToRoute("affichage_Produits");
        }
        return $this->render("/produit/back_office/ajouter.html.twig", [
            'produitForm' => $form->createView()
        ]);
    }




    /**
     * @route("/produit/editer/{id}", name="editerProduit")
     */


    public function editerProduit(Request $request, ProduitRepository $repo, $id)
    {
        $produit = $repo->find($id);

        $imageName = $produit->getImage();

        $form = $this->createForm(ProduitType::class, $produit);

        #$form->handleRequest($request);
        $form->submit($request->request->get($form->getName()), false);

        if (($form->isSubmitted()) && ($form->isValid())) {

            $file = $request->files->get('produit')['image'];
            if ($file != null) {
                $uploads_directory = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $fileName
                );
                $produit->setImage($fileName);
            } else {
                $produit->setImage($imageName);
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($produit);

            $em->flush();


            $this->addFlash('success', 'Produit modifié avec succès');
            return $this->redirectToRoute("affichage_Produits");
        }
        return $this->render("/produit/back_office/edit.html.twig", [
            'produitForm' => $form->createView()
        ]);
    }
    /**
     * @route("/produit/supprimer/{id}", name="supprimerProduit")
     */

    public function supprimerProduit($id, ProduitRepository $repo)
    {

        $produit = $repo->find($id);
        $image = $produit->getImage();

        if ($image) {
            $nomImage = $this->getParameter("uploads_directory") . '/' . $image;
            if (file_exists($nomImage)) {
                unlink($nomImage);
            }
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        $this->addFlash('success', 'Produit supprimé avec succès');
        return $this->redirectToRoute("affichage_Produits");
    }

    /**
     * @route("/produit/details/{id}", name="detailsProduit")
     */


    public function detailsProduit($id, ProduitRepository $rep)
    {
        $produit = $rep->find($id);

        return $this->render('/produit/back_office/details.html.twig', [
            'produit' => $produit
        ]);
    }


    /**
     * @route("produit/Findex" ,name="affichageProduitFront")
     */


    public function affichageFrontProduit(Request $request, ProduitRepository $repo, ClientRepository $ClientRepo, FollowingproduitRepository $followRepo)
    {
        $data = new SearchData();
        $formSearch = $this->createForm(SearchForm::class, $data);
        $Products = $repo->findAll();

        $search = $formSearch->handleRequest($request);
        $Products = $repo->findSearch($data);

        $client = $ClientRepo->find(1);
        $followings = $client->getFollowings();

        $listFollowedProduit = array();

        foreach ($followings as $following) {
            $listFollowedProduit[] = $following->getProduit();
        }

        $followRepo->count(['client' => $client]);

        return $this->render('/produit/front_office/index.html.twig', array(
            'listFollowedProduit' => $listFollowedProduit,
            'products' => $Products,
            'countFollowings' => $followRepo,
            'formSearch' => $formSearch->createView()
        ));
    }


    /**
     * @route("produit/Fdetails/{id}", name="detailsProduitFront")
     */


    public function afficherDetailsProduit(ProduitRepository $repo, $id)
    {
        $product = $repo->find($id);
        return $this->render('/produit/front_office/details.html.twig', [
            'produit' => $product
        ]);
    }



    /**
     * @return boolean
     */

    public function isFollowed($idProduit, $idClient): bool
    {
        $repo = $this->getDoctrine()->getRepository(Followingproduit::class);
        $p = $repo->findOneBy(array('idproduit' => $idProduit, 'idclient' => $idClient));

        if ($p) return true;
        else return false;
    }

    /**
     * @Route("/produit/follow/{idProduit}/{idClient}", name="produit_follow")
     */


    public function follow($idProduit, $idClient, FollowingproduitRepository $followRepo): Response
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

        $client = $this->getDoctrine()->getRepository(Client::class)->find($idClient);


        if ($produit->isFollowedByUser($client)) {
            $FP = $followRepo->findOneBy(array('produit' => $produit, 'client' => $client));
            $em = $this->getDoctrine()->getManager();
            $em->remove($FP);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => "est retiré à votre wishlist",
                'followings' => $followRepo->count(['client' => $client])
            ], 200);
        }

        $FP = new Followingproduit();
        $em = $this->getDoctrine()->getManager();


        $FP->setProduit($produit)
            ->setClient($client);
        $em->persist($FP);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => "est ajouté à votre wishlist, vous recevrez un e-mail lorsqu'il sera de nouveau en stock ",
            'followings' => $followRepo->count(['client' => $client])
        ], 200);
    }

    /**
     *@route("/produit/wishList/{idClient}", name="MyWishList")
     */


    public function displayFollowings($idClient, ClientRepository $ClientRepo)
    {

        $client = $ClientRepo->find($idClient);
        $followings = $client->getFollowings();

        $listProduit = array();

        foreach ($followings as $following) {
            $listProduit[] = $following->getProduit();
        }

        return $this->render('/produit/front_office/index1.html.twig', [
            'listProduits' => $listProduit
        ]);
    }
    /**
     * @route("/upload", name="upload_CSV")
     */

    public function uploadCSVFile(Request $request, ProduitRepository $produitRepo)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {

            // Pull the uploaded file information
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $request->files->get('file')->getClientOriginalName();

            if ($file != null) {
                $uploads_directory = $this->getParameter('uploads_directory');
                $inputFile = $uploads_directory . '/' . $file;
                $decoder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
                $products = $decoder->decode(file_get_contents($inputFile), 'csv');
                //dd($products);
                foreach ($products as $P) {

                    $existingProduct = $produitRepo->find(['idproduit' => $P['IDProduit']]);

                    if ($existingProduct) {
                        $existingProduct->setDesignation($P['Designation']);
                        $existingProduct->setDescription($P['Description']);
                        $existingProduct->setImage($P['Image']);
                        $existingProduct->setQuantiteenstock($P['QuantiteEnStock']);
                        $existingProduct->setPrixachatunit($P['prixAchatUnit']);
                        $existingProduct->setPrixventeunit($P['prixVenteUnit']);
                        $existingProduct->setStatusstock($P['StatusStock']);

                        $em->persist($existingProduct);
                        $em->flush();
                    } else {

                        $produit = new Produit();

                        $produit->setDesignation($P['Designation']);
                        $produit->setDesignation($P['Designation']);
                        $produit->setDescription($P['Description']);
                        $produit->setImage($P['Image']);
                        $produit->setQuantiteenstock($P['QuantiteEnStock']);
                        $produit->setPrixachatunit($P['prixAchatUnit']);
                        $produit->setPrixventeunit($P['prixVenteUnit']);
                        $produit->setStatusstock($P['StatusStock']);

                        $em->persist($produit);
                        $em->flush();
                    }
                }
            }
        }

        return $this->render('/produit/back_office/importCSV.html.twig');
    }
}
