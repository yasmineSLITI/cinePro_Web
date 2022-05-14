<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Entity\Facture;
use App\Entity\Produit;
use App\Entity\Client;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\ClientRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Form\PanierType;
use App\Entity\Adresse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="app_panier")
     */
    public function index(): Response
    {
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
    /**
     * @Route("/read", name="read")
     */
    public function read()
    {
        $listec = $this->getDoctrine()->getRepository(Panier::class)
            ->findAll();
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'liste' => $listec
        ]);
    }
    /**
     * @Route("/delete/{id1}", name="delete" ,requirements={"id1" = "<code>/\d/+</code>"}, defaults={"id1" = 1})
     */
    public function delete($id1)
    {
        $listesup = $this->getDoctrine()->getRepository(Panier::class)
            ->findOneBy(array('idpanier' => $id1));
        $em = $this->getDoctrine()->getManager();
        $em->remove($listesup);
        $em->flush();
        return $this->redirectToRoute("read");
    }
    /**
     * @Route("/vider", name="vider")
     */
    public function vider(PanierRepository $panierRepo)
    {
        $listesup = $panierRepo->viderPnier();

        return $this->redirectToRoute("read");
    }

    /**
     * @Route("/valider/{id}", name="valider")
     */
    public function valider($id, ProduitRepository $produitRepo, PanierRepository $panierRepo)
    {
        $idpanier = $this->getDoctrine()->getRepository(Panier::class)->find($id);
        $client = new Client();
        $role = $client->getRole();
        $prix = $produitRepo->getPrix();
        $qt = $panierRepo->getQt();
        //dd($prix);
        if ($role == "etudiant") {
            $fact = new Facture();
            $fact->setTotal($prix * $qt * 0.2);
            $fact->setDatecreation(new \DateTime('now'));
            $fact->setIdpanier($idpanier);



            $em = $this->getDoctrine()->getManager();

            $em->persist($fact);
            $em->flush();
        } else {
            $fact = new Facture();
            $fact->setTotal($prix * $qt);
            $fact->setDatecreation(new \DateTime('now'));
            $fact->setIdpanier($idpanier);



            $em = $this->getDoctrine()->getManager();
            //$student->setMoyenne(0);
            $em->persist($fact);
            $em->flush();
        }


        $listec = $this->getDoctrine()->getRepository(Facture::class)->findAll();
        return $this->render('facture/factur.html.twig', [
            "ff" => $listec
        ]);
    }
    /**
     * @Route("/updatePanier/{id}", name="updatePanier")
     */
    public function updatePanier(Request $request, $id)
    {
        $panier = $this->getDoctrine()->getRepository(Panier::class)->find($id);
        $form = $this->createForm(PanierType::class, $panier);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->render("panier/update.html.twig", array('form' => $form->createView()));
    }

    /**
     * @Route("/ajouterfacture/new/{id}", name="ajouterfacture")
     */
    public function ajouterfacture(Request $request, NormalizerInterface $Normalizer, $id, ProduitRepository $produitRepo, PanierRepository $panierRepo)
    {
        $idpanier = $this->getDoctrine()->getRepository(Panier::class)->find($id);
        $client = new Client();
        $role = $client->getRole();
        $prix = $produitRepo->getPrix();
        $qt = $panierRepo->getQt();
        //dd($prix);
        if ($role == "etudiant") {
            $fact = new Facture();
            $fact->setTotal($prix * $qt * 0.2);
            $fact->setDatecreation(new \DateTime('now'));
            $fact->setIdpanier($idpanier);



            $em = $this->getDoctrine()->getManager();

            $em->persist($fact);
            $em->flush();
        } else {
            $fact = new Facture();
            $fact->setTotal($prix * $qt);
            $fact->setDatecreation(new \DateTime('now'));
            $fact->setIdpanier($idpanier);



            $em = $this->getDoctrine()->getManager();
            //$student->setMoyenne(0);
            $em->persist($fact);
            $em->flush();
        }


        $jsonContent = $Normalizer->normalize($fact, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/ListePanier", name="ListePanier")
     */
    public function ListePanier(NormalizerInterface $Normalizer)
    {
        $listec = $this->getDoctrine()->getRepository(Panier::class)
            ->findAll();
        $jsonContent = $Normalizer->normalize($listec, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/supprimerPanier", name="supprimerPanier")
     */
    public function supprimerPanier(NormalizerInterface $Normalizer)
    {
        $listesup = $this->getDoctrine()->getRepository(Panier::class)
            ->viderPnier();

        $jsonContent = $Normalizer->normalize($listesup, 'json', ['groups' => 'post:read']);
        return new Response("panier supprimé avec succés" . json_encode($jsonContent));
    }
}
