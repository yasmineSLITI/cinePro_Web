<?php

namespace App\Controller;

use App\Entity\Demandedesponsoring;
use App\Form\Demandedesponsoring1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demandedesponsoring/controller/copy")
 */
class DemandedesponsoringControllerCopyController extends AbstractController
{
    /**
     * @Route("/", name="app_demandedesponsoring_controller_copy_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $demandedesponsorings = $entityManager
            ->getRepository(Demandedesponsoring::class)
            ->findAll();

        return $this->render('demandedesponsoring_controller_copy/index.html.twig', [
            'demandedesponsorings' => $demandedesponsorings,
        ]);
    }

    /**
     * @Route("/new", name="app_demandedesponsoring_controller_copy_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demandedesponsoring = new Demandedesponsoring();
        $form = $this->createForm(Demandedesponsoring1Type::class, $demandedesponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandedesponsoring);
            $entityManager->flush();

            return $this->redirectToRoute('app_demandedesponsoring_controller_copy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demandedesponsoring_controller_copy/new.html.twig', [
            'demandedesponsoring' => $demandedesponsoring,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iddemande}", name="app_demandedesponsoring_controller_copy_show", methods={"GET"})
     */
    public function show(Demandedesponsoring $demandedesponsoring): Response
    {
        return $this->render('demandedesponsoring_controller_copy/show.html.twig', [
            'demandedesponsoring' => $demandedesponsoring,
        ]);
    }

    /**
     * @Route("/{iddemande}/edit", name="app_demandedesponsoring_controller_copy_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Demandedesponsoring $demandedesponsoring, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Demandedesponsoring1Type::class, $demandedesponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demandedesponsoring_controller_copy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demandedesponsoring_controller_copy/edit.html.twig', [
            'demandedesponsoring' => $demandedesponsoring,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iddemande}", name="app_demandedesponsoring_controller_copy_delete", methods={"POST"})
     */
    public function delete(Request $request, Demandedesponsoring $demandedesponsoring, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandedesponsoring->getIddemande(), $request->request->get('_token'))) {
            $entityManager->remove($demandedesponsoring);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demandedesponsoring_controller_copy_index', [], Response::HTTP_SEE_OTHER);
    }
}
