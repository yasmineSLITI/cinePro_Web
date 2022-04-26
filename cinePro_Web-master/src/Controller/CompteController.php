<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Form\CompteType1Type;
use ContainerJ3KnLJ5\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class CompteController extends AbstractController
{
    /**
     * @Route("/", name="app_compte_index", methods={"GET"})
     */
    public function index(Request $request , PaginatorInterface $paginator): Response
    {
        $allcomptes = $this->getDoctrine()
            ->getRepository(Compte::class)
            ->findAll();
            //Paginate the results of the query
        $comptes= $paginator->paginate(
        // Doctrine Query, not results
            $allcomptes,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
    );

        return $this->render('compte/index.html.twig', [
            'comptes' => $comptes,
        ]);
    }

    /**
     * @Route("/new", name="app_compte_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoderpassword, MailerInterface $mailer): Response
    {
        
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compte->setPassword($encoderpassword->encodePassword($compte, $request->get('compte')['password']));
            $compte->setUsername(uniqid());
            $target_dir = "uploads/";
            
            $target_file = $target_dir . basename($_FILES["compte"]["name"]["image"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $new_name = rand().'.'.$imageFileType;

            move_uploaded_file($_FILES["compte"]["tmp_name"]["image"], "uploads/".$new_name);
            $compte->setImage($new_name);
            $entityManager->persist($compte);
            $entityManager->flush();
            $email = (new  TemplatedEmail())
           ->from('noreplyCinepro@gmail.com')
    // On attribue le destinataire
            ->to($compte->getMail())
    // On crée le texte avec la vue
    ->subject('Time for Symfony Mailer!')
    ->htmlTemplate('compte/new.html.twig')
    ->context([
        
        'nom' => $form["nom"]->getData(),
    ]);
     $mailer->send($email);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte/new.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{username}", name="app_compte_show", methods={"GET"})
     */
    public function show(Compte $compte): Response
    {
        return $this->render('compte/show.html.twig', [
            'compte' => $compte,
        ]);
    }

    /**
     * @Route("/{username}/edit", name="app_compte_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteType1Type::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte/edit.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{username}/edit1", name="app_compte_edit1", methods={"GET", "POST"})
     */
    public function edit1(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteType1Type::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte/edit.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{username}", name="app_compte_delete", methods={"POST"})
     */
    public function delete(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compte->getUsername(), $request->request->get('_token'))) {
            $entityManager->remove($compte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_compte_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
