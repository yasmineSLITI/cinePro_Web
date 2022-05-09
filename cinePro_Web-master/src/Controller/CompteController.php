<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Form\Compte1Type;
use App\Form\Compte3Type;
use Symfony\Component\Mime\Email;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @Route("/compte")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/", name="app_compte_index", methods={"GET"})
     */
    public function index(CompteRepository $compteRepository, PaginatorInterface $paginator, EntityManagerInterface $entityManager, Request $request): Response
    {
        $comptes = $entityManager
            ->getRepository(Compte::class)
            ->findAll();
            $comptes = $paginator->paginate(
                $comptes,
                $request->query->getInt('page',1),
                4
            );
        return $this->render('compte/index.html.twig', [
            'comptes' => $compteRepository->findAll(),
            
        ]);
    }

    /**
     * @Route("/Rea", name="app_compte_index_rea", methods={"GET"})
     */
    public function index1(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {   
        $entityManager=$this->getDoctrine()->getManager();
        $comptes = $entityManager->getRepository(Compte::class)->byRole("ROLE_REALISATEUR");
        $comptes = $paginator->paginate(
            $comptes,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('compte/index1.html.twig', [
            'comptes'=>$comptes
        ]);
    }

    /**
     * @Route("/Presse", name="app_compte_index_Presse", methods={"GET"})
     */
    public function index2(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {   
        $entityManager=$this->getDoctrine()->getManager();
        $comptes = $entityManager->getRepository(Compte::class)->byRole("ROLE_PRESSE");
        return $this->render('compte/index2.html.twig', [
            'comptes'=>$comptes
        ]);
    }
    /**
     * @Route("/Sponsor", name="app_compte_index_Sponsor", methods={"GET"})
     */

    public function index3(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {  
        $entityManager=$this->getDoctrine()->getManager();
        $comptes = $entityManager->getRepository(Compte::class)->byRole("ROLE_SPONSOR");
        return $this->render('compte/index3.html.twig', [
            'comptes'=>$comptes
        ]);
    }

    /**
     * @Route("/new", name="app_compte_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompteRepository $compteRepository, MailerInterface $mailer, UserPasswordEncoderInterface $encoderpassword): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(in_array('ROLE_SPONSOR',$compte->getRoles()))
            {
                $random=rand(100,999).'SPO'.rand(100,999);
                
                $compte->setUsername($random);
    
            }
            if(in_array('ROLE_PRESSE',$compte->getRoles()))
            {
                $random=rand(100,999).'PRE'.rand(100,999);
                $compte->setUsername($random);
    
            }
            if(in_array('ROLE_REALISATEUR',$compte->getRoles()))
            {
                $random=rand(100,999).'REA'.rand(100,999);
                $compte->setUsername($random);
    
            }
            if(in_array('ROLE_CLIENT',$compte->getRoles()))
            {
                $random=rand(100,999).'CLI'.rand(100,999);
                $compte->setUsername($random);
    
            }
           
            $compte->setPassword($encoderpassword->encodePassword($compte, $request->get('compte')['password']));
           
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["compte"]["name"]["image"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $new_name = rand().'.'.$imageFileType;

            move_uploaded_file($_FILES["compte"]["tmp_name"]["image"], "uploads/".$new_name);
            $compte->setImage($new_name);
            $entityManager = $this->getDoctrine()->getManager();
            $compteRepository->add($compte);
            $email = (new TemplatedEmail())
            ->from('salemzitoun.medamine@esprit.tn')
            ->to($compte->getMail())
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Bienvenue au JCC')
            ->text('Welcome')
            ->htmlTemplate('email/inscription.html.twig')
            ->context([
                'compte' => $compte
            ])
            ;


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
    public function edit(Request $request, Compte $compte,  EntityManagerInterface $entityManager): Response
    {  
        
        $form = $this->createForm(Compte1Type::class, $compte);
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
    public function delete(Request $request, Compte $compte, CompteRepository $compteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compte->getUsername(), $request->request->get('_token'))) {
            $compteRepository->remove($compte);
            

        }

        return $this->redirectToRoute('app_compte_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/forget/Pssword", name="forgetPssword")
     */
    public function forgetPssword(Request $request, CompteRepository $compteRepository,MailerInterface $mailer)
    {
        $error='';
        
      if($request->isMethod('POST'))
      {
          $compte=$compteRepository->findOneBy(['mail'=>$request->get('email')]);
          if($compte)
          {

            $email = (new TemplatedEmail())
            ->from('salemzitoun.medamine@esprit.tn')
            ->to($compte->getMail())
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('lien de changement de mot depasse')
            ->htmlTemplate('email/linkPassword.html.twig')
            ->context([
                'compte' => $compte,'url'=>'http://127.0.0.1:8000/compte/forget/Pssword/'.$compte->getUsername()
            ])
            ;


        $mailer->send($email);

          }
          else
          {
              $error='email on plus';
          }
      }

        return $this->render('compte/forgetPssword.html.twig', ['error'=>$error]);
    }

    /**
     * @Route("/forget/Pssword/{token}", name="forgetPsswordToken")
     */
    public function forgetPsswordToken(Request $request,$token, CompteRepository $compteRepository,UserPasswordEncoderInterface $encoderpassword)
    {
        $error='';

        $compte=$compteRepository->findOneBy(['username'=>$token]);
        if($compte)
        {

            if($request->isMethod('POST'))
            {

                $compte->setPassword($encoderpassword->encodePassword($compte, $request->get('password')));
                $this->getDoctrine()->getManager()->flush();
                
                return $this->redirectToRoute('app_login');
            }

            return $this->render('compte/forgetPsswordToken.html.twig',['token'=>$token]);

           
        }

        return $this->redirectToRoute('app_compte_new');

    }


      
}