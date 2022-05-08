<?php

namespace App\Controller;
use App\Entity\Film;
use App\Entity\Realisateur;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Knp\Component\Pager\PaginatorInterface;

class RealisateurController extends AbstractController
{
    /**
     * @Route("/realisateur", name="app_realisateur")
     */
    public function index(): Response
    {
        return $this->render('RealisateurBackOffice.html.twig', [
            'controller_name' => 'RealisateurController',
        ]);
    }
    /**
     * @param FilmRepository $repo
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/realisateur/AfficheF", name="app_film")
     */
    public function Affiche(FilmRepository $repo,PaginatorInterface $paginator,Request $request){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $data =$repo->findAll();
        $film=$paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            3
        );
        return $this->render('realisateur/Affiche.html.twig',
    ['film'=>$film]);
    }
     /**
     * @Route("/realisateur/Supprimer/{id}", name="suppression")
     */
    public function Supprimer($id,FilmRepository $repo){
        //$repo=$this->getDoctrine()->getRepository(Film::class);
        $film =$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($film);
        $em->flush();
        //$this->addFlash('message','Film Supprimé avec succés');
        return $this->redirectToRoute('app_film');
    }
  
     
     /**
     * @Route("/realisateur/Detaill/{id}", name="detailRea")
     */
    public function detail($id): Response
    {
        $detail = $this->getDoctrine()->getRepository(film::class)->find($id);
         
       
        return $this->render('realisateur/details.html.twig', [
            
            'detail'=> $detail,
           

        ]);
    }
    
    /**
     * @param Request $request
     * @return \Symphony\Component\HttpFoundation\Response
     * @Route("/realisateur/Modifier/{id}", name="m")
     */
    
    public function Update(FilmRepository $repo,$id,Request $request){
        $film=$repo->find($id);
        $imageName = $film->getImage();
        $form=$this->createForm(FilmType::class,$film);
        #$form->submit($request->request->get($form->getName()), false);
      
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $file = $request->files->get('film')['image'];
            if ($file != null) {
                $uploads_directory = $this->getParameter('image_directory');
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $fileName
                );
                $film->setImage($fileName);
            } else {
                $film->setImage($imageName);
            }
            $em=$this->getDoctrine()->getManager();
            
            $em->flush();
            return $this->redirectToRoute('app_film');
        }
        return $this->render('realisateur/Modifier.html.twig',[
            'form'=>$form->createView()
        ]);
    }
     
}
