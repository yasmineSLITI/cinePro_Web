<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Form\FilmmType;
use App\Entity\Realisateur;
use App\service\MailerService;
use App\Repository\AvisRepository;
use App\Repository\FilmRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FilmController extends AbstractController
{
    /**
     * @Route("/film", name="app4")
     */
    public function index(): Response
    {
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);
    }
    /**
     * @param FilmRepository $repo
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/film/Afficher", name="appp")
     */
    public function Affiche(FilmRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $data = $repo->findAll();
        $film = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render(
            'Film/Affiche.html.twig',
            ['film' => $film]
        );
    }
    /**
     * @Route("/Supprimer/{id}", name="supp")
     */
    public function Supprimer($id, FilmRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $film = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($film);
        $em->flush();
        //$this->addFlash('message','Film Supprimé avec succés');
        return $this->redirectToRoute('appp');
    }


    /**
     * @Route("/film/Detaill/{id}", name="de")
     */
    public function detail($id): Response
    {
        $detail = $this->getDoctrine()->getRepository(film::class)->find($id);


        return $this->render('film/details.html.twig', [

            'detail' => $detail,


        ]);
    }

    /**
     * @param Request $request
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/film/Modifier/{id}", name="mF")
     */
    public function Update(
        FilmRepository $repo,
        $id,
        Request $request,
        \Swift_Mailer $mailer,
        MailerService $mailerService
    ): Response {

        $film = $repo->find($id);

        $form = $this->createForm(FilmmType::class, $film);
        #$form->submit($request->request->get($form->getName()), false);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('appp');
        }
        $mailerService->send(
            "Bienvenue dans jcc votre film est accepté",
            "yosr.sahnoun1@esprit.tn",
            "yosr.sahnoun1@esprit.tn",

            "MailTemplate/emailTemplate.html.twig"
        );



        return $this->render('film/Modifier.html.twig', [
            'film' => $film,
            'form' => $form->createView()
        ]);
    }
    /**
     * @param Request $request
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/film/Ajouter", name="a")
     */
    public function add(Request $request)
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')->getData();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $film->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            return $this->render('realisateur/show.html.twig', ['film' => $film]);
        }
        return $this->render('film/Ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param FilmRepository $repo
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/film/Afficher/json", name="apppjson")
     */
    public function Affichejson()
    {
        $repo = $this->getDoctrine()->getRepository(Film::class);
        $film = $repo->findAll();
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Film s ');
        $film = $qb->getArrayResult();
        $response = new Response(json_encode($film));
        return $response;
    }


    /**
     * @param Request $request
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/film/Ajouter/json", name="AjoutJ")
     */
    public function addjson(Request $request, NormalizerInterface $Normalizer)
    {
        $film = new Film();
        $em = $this->getDoctrine()->getManager();
        $film->setImage($request->get('image'));
        $film->setNomf($request->get('nomf'));
        $film->setDuree($request->get('duree'));
        $film->setDescription($request->get('description'));
        $film->setGenre($request->get('genre'));
        $film->setNumrea($this->getDoctrine()->getRepository(Film::class)->find($request->get('numrea')));


        $em->persist($film);
        $em->flush();
        $qb = $this->getDoctrine()->getManager()->createQuery('select s from App\Entity\Film s where s.idf = :v1')->setParameter('v1', $film->getIdf());
        $film = $qb->getArrayResult();
        $response = new Response(json_encode($film));
        return $response;
    }
}
