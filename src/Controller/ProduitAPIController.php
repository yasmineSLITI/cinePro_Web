<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produit;
use App\Entity\Followingproduit;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FollowingproduitRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File as FileFile;

class ProduitAPIController extends AbstractController
{

    /**
     * @Route("/products", name="api_products")
     */
    public function index(NormalizerInterface $normalizer): Response
    {
        $productsList = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $jsonContent = $normalizer->normalize($productsList, 'json', ['groups' => 'api:produit']);
        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }
    /**
     * @Route("/product/addProduct", name="api_add_product")
     */
    public function addProduct(NormalizerInterface $normalizer, Request $request): Response
    {
        $produit = new Produit();
        $produit->setDesignation($request->get('designation'));
        $produit->setDescription($request->get('description'));
        //$produit->setImage($request->get('image'));
        $produit->setQuantiteenstock($request->get('quantiteenstock'));
        $produit->setPrixachatunit($request->get('prixachatunit'));
        $produit->setPrixventeunit($request->get('prixventeunit'));
        $file = new FileFile($request->get('image'));


        $filename = md5(uniqid()) . '.jpeg';
        $file->move($this->getParameter('uploads_directory'), $filename);
        $produit->setImage($filename);

        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $jsonContent = $normalizer->normalize($produit, 'json', ['groups' => 'api:produit']);
        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @Route("/product/updateProduct/{id}", name="api_update_product")
     */
    public function updateProduct(NormalizerInterface $normalizer, Request $request, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        $produit->setDesignation($request->get('designation'));
        $produit->setDescription($request->get('description'));
        $file = $request->files->get('produit')['image'];
        if ($file != null) {
            $uploads_directory = $this->getParameter('uploads_directory');
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $fileName
            );
            $produit->setImage($fileName);
        }
        $produit->setQuantiteenstock($request->get('quantiteenstock'));
        $produit->setPrixachatunit($request->get('prixachatunit'));
        $produit->setPrixventeunit($request->get('prixventeunit'));
        $produit->setStatusstock($request->get('statusstock'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $jsonContent = $normalizer->normalize($produit, 'json', ['groups' => 'api:produit']);
        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @Route("/product/delete/{id}", name="api_product_delete")
     */
    public function delete(Request $request, NormalizerInterface $normalizer, $id): Response
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $image = $produit->getImage();

        if ($image) {
            $nomImage = $this->getParameter("uploads_directory") . '/' . $image;
            if (file_exists($nomImage)) {
                unlink($nomImage);
            }
        }
        $em->remove($produit);
        $em->flush();
        return new Response(
            "{\"response\": \"{$request->query->get('designation')} deleted.\"}",
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @route("/product/details/{id}", name="api_product_details")
     */
    public function detailsProduitMobile($id, NormalizerInterface $Normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        $jsonContent = $Normalizer->normalize($produit, 'json', ['groups' => 'api:produit']);
        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @Route("/product/unfollow/{idProduit}/{idClient}", name="api_unfollow_product")
     */


    public function unfollow($idProduit, $idClient, FollowingproduitRepository $followRepo, NormalizerInterface $Normalizer): Response
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

        $client = $this->getDoctrine()->getRepository(Client::class)->find($idClient);

        $FP = $followRepo->findOneBy(array('produit' => $produit, 'client' => $client));
        $em = $this->getDoctrine()->getManager();
        $em->remove($FP);
        $em->flush();

        return new Response(
            "{\"response\": \"{$produit->getDesignation()} est retiré de votre wishList .\"}",
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @Route("/product/follow/{idProduit}/{idClient}", name="api_follow_product")
     */

    public function follow($idProduit, $idClient, FollowingproduitRepository $followRepo, NormalizerInterface $Normalizer): Response
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

        $client = $this->getDoctrine()->getRepository(Client::class)->find($idClient);

        $FP = new Followingproduit();
        $em = $this->getDoctrine()->getManager();


        $FP->setProduit($produit)
            ->setClient($client);
        $em->persist($FP);
        $em->flush();

        return new Response(
            "{\"response\": \"{$produit->getDesignation()} est ajouté à votre wishlist.\"}",
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     * @Route("/product/isFollowed/{idProduit}/{idClient}", name="api_product_isFollowed", methods={"GET"})
     */
    public function isFollowed(Request $request, $idProduit, $idClient): Response
    {

        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

        $client = $this->getDoctrine()->getRepository(Client::class)->find($idClient);


        if ($produit->isFollowedByUser($client))
            return new Response(
                "{\"response\": \"True\"}",
                200,
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            );
        else
            return new Response(
                "{\"response\": \"False\"}",
                200,
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            );
    }

    /**
     * @route("product/LikedProducts" ,name="api_liked_products")
     */


    public function allFollowedProducts(FollowingproduitRepository $followRepo, NormalizerInterface $Normalizer)
    {

        $Products = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $client = $this->getDoctrine()->getRepository(Client::class)->find(1);

        $followings = $client->getFollowings();
        $listFollowedProduit = array();
        foreach ($followings as $following) {
            $listFollowedProduit[] = $following->getProduit();
        }


        $wishList = array();

        foreach ($listFollowedProduit as $row) {
            $wishList[] = $Normalizer->normalize($row, 'json', ['groups' => 'api:produit']);
        }

        return new Response(
            json_encode($wishList),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }
    /**
     * @route("/produit/isLiked/{idProduit}/{idClient}" , name="api_isLiked_By")
     */

    public function isLikedBy($idProduit, $idClient, FollowingproduitRepository $followRepo, NormalizerInterface $normalizer)
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

        $client = $this->getDoctrine()->getRepository(Client::class)->find($idClient);


        if ($produit->isFollowedByUser($client)) {
            $jsonContent = $normalizer->normalize(true, 'json');
            return new Response(
                json_encode($jsonContent),
                200,
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            );
        }
        $jsonContent = $normalizer->normalize(false, 'json');
        return new Response(
            json_encode($jsonContent),
            200,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
    }
}
