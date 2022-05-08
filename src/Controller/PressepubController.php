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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\File\UploadFile;
use Knp\Component\Pager\PaginatorInterface;

class PressepubController extends AbstractController
{
    /**
     * @Route("/presse/p", name="appPresse")
     */

    public function publication1(Request $request): Response
    {



        return $this->render('pressepub/index.html.twig', []);
    }
    /**
     * @Route("/presse/listepub", name="publicationPresse")
     */

    public function publication(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Publication::class)->findAll();
        $pub = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('pressepub/listepub.html.twig', [

            'publications' => $pub,
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
            $file = $form->get('imgpub')->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('images_directory'), $fileName);
            $Publication->setImgpub($fileName);


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($Publication);
            $entityManager->flush();


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
    public function Supprimer($id, PublicationRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $pub = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($pub);
        $em->flush();

        //$this->addFlash('message','Film Supprimé avec succés');
        return $this->redirectToRoute('publicationPresse');
    }

    /**
     * @Route("/modifier/{id}", name="modifierPub")
     */
    public function Modifier($id, PublicationRepository $repo, Request $request)
    {


        $pub = $repo->find($id);
        $imageName = $pub->getImgpub();
        $form = $this->createForm(PublicationType::class, $pub);
        #$form->handleRequest($request);
        $form->submit($request->request->get($form->getName()), false);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('publication')['imgpub'];
            if ($file != null) {
                $uploads_directory = $this->getParameter('images_directory');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $fileName
                );
                $pub->setImgpub($fileName);
            } else {
                $pub->setImgpub($imageName);
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($pub);

            $em->flush();


            return $this->redirectToRoute("publicationPresse");
        }

        return $this->render('pressepub/modifierpubpresse.html.twig', [
            'pub' => $pub,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/archiver/{id}", name="archiverPub")
     */
    public function archiver($id, PublicationRepository $repo, Request $request)
    {

        $pub = $repo->find($id);
        $pub->setArchive(1);

        $em = $this->getDoctrine()->getManager();

        $em->persist($pub);

        $em->flush();

        return $this->redirectToRoute("publicationPresse");
    }
    //-----------------------------JSON------------------------------

    /**
     * @Route("/allPubs/json", name="allPubs")
     */
    public function allPubs(NormalizerInterface $normalizer): Response
    {
        $pubs  = $this->getDoctrine()->getRepository(Publication::class)->findAll();
        $jsonContent = $normalizer->normalize($pubs, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/addPubJson/{id}", name="addPubJson")
     */
    public function addPubsJson(Request $request, NormalizerInterface $normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $pub = new Publication();
        $pub->setIdpresse($this->getDoctrine()->getRepository(Presse::class)->find($id));
        $pub->setTitre($request->get('titre'));
        $pub->setTxtpub($request->get('txtpub'));
        $pub->setImgpub($request->get('imgpub'));



        $em->persist($pub);
        $em->flush();
        $jsonContent = $normalizer->normalize($pub, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deletePubsJson/{id}", name="deletePubsJson")
     */
    public function deleteJSON(Request $request, NormalizerInterface $normalizer, $id): Response
    {

        $em = $this->getDoctrine()->getManager();
        $pub = $em->getRepository(Publication::class)->find($id);
        $em->remove($pub);
        $em->flush();
        $jsonContent = $normalizer->normalize($pub, 'json', ['groups' => 'post:read']);
        return new Response("pub deleted successfully" . json_encode($jsonContent));
    }

    /**
     * @Route("/editPubJson/{id}", name="editPubJson")
     */
    public function editPubJson($id, Request $request, NormalizerInterface $normalizer, PublicationRepository $rep): Response
    {
        $em = $this->getDoctrine()->getManager();
        $pub = $rep->find($id);
        $pub->setTitre($request->get('titre'));
        $pub->setTxtpub($request->get('txtpub'));
        $pub->setImgpub($request->get('imgpub'));
        $em->flush();
        $jsonContent = $normalizer->normalize($pub, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }
}
