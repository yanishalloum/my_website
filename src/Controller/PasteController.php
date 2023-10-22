<?php

namespace App\Controller;

use App\Entity\Paste;
use App\Form\PasteType;
use App\Repository\PasteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/paste')]
class PasteController extends AbstractController
{
    #[Route('/', name: 'app_paste_index', methods: ['GET'])]
    public function index(PasteRepository $pasteRepository): Response
    {
        return $this->render('paste/index.html.twig', [
            'pastes' => $pasteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_paste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $paste = new Paste();
        $form = $this->createForm(PasteType::class, $paste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($paste);
            $entityManager->flush();

            return $this->redirectToRoute('app_paste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paste/new.html.twig', [
            'paste' => $paste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paste_show', methods: ['GET'])]
    public function show(Paste $paste): Response
    {
        return $this->render('paste/show.html.twig', [
            'paste' => $paste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_paste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paste $paste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PasteType::class, $paste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_paste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paste/edit.html.twig', [
            'paste' => $paste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paste_delete', methods: ['POST'])]
    public function delete(Request $request, Paste $paste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paste->getId(), $request->request->get('_token'))) {
            $entityManager->remove($paste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_paste_index', [], Response::HTTP_SEE_OTHER);
    }
}
