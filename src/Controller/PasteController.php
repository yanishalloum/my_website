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
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
        $form = $this->createForm(PasteType::class, $paste, ['task_is_new' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($paste);
            $entityManager->flush();
            
            $this->addFlash('message', 'bien ajouté');
            
            // Change content-type according to image's
            $imagefile = $paste->getImageFile();
            if($imagefile) {
                    $mimetype = $imagefile->getMimeType();
                    $paste->setContentType($mimetype);
            }
                    
            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'bien ajouté');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()

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
    #[IsGranted('ROLE_USER')]
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
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Paste $paste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paste->getId(), $request->request->get('_token'))) {
            $entityManager->remove($paste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_paste_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/mark/{id}', name: 'paste_mark', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function markAction(Request $request, Paste $paste): Response
    {
        $id = $paste->getId();
        // Récupération du tableau d'id urgents dans la session
        $urgents = $request->getSession()->get('urgents');
        dump($urgents);
        if( ! is_array($id, $urgents) ) {
                $urgents[] = $id;
        }
        else {
            // substract two arrays
            $urgents = array_diff($urgents, array($id));
        }
        

        dump($urgents);
        // Sauvegarde du tableau d'id urgents dans la session
        $request->getSession()->set('urgents', $urgents);

        dump($paste);
        return $this->redirectToRoute('paste_show', 
            ['id' => $paste->getId()]);
    }

}
