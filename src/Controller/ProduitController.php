<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Client;
use App\Form\ProduitType;
use App\Entity\Followingproduit;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FollowingproduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="affichage_Produits")
     */
    public function index(ProduitRepository $repo)
    {

        $Products = $repo->findAll();

        return $this->render('produit/back_office/index.html.twig', [
            'products' => $Products,
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


    public function affichageFontProduit(ProduitRepository $repo)
    {
        $Products = $repo->findAll();
        return $this->render('/produit/front_office/index.html.twig', [
            'products' => $Products
        ]);
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
                'message' => "est retiré à votre wishlist"
            ]);
        }

        $FP = new Followingproduit();
        $em = $this->getDoctrine()->getManager();


        $FP->setProduit($produit)
            ->setClient($client);
        $em->persist($FP);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => "est ajouté à votre wishlist, vous recevrez un e-mail lorsqu'il sera de nouveau en stock "
        ]);
    }
}
