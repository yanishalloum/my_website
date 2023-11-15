<?php

namespace App\Controller;

use App\Entity\Cap;
use App\Entity\Inventory;
use App\Form\CapType;
use App\Repository\CapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/cap')]
class CapController extends AbstractController
{
    #[Route('/', name: 'app_cap_index', methods: ['GET'])]
    public function index(CapRepository $capRepository): Response
    {
        return $this->render('cap/index.html.twig', [
            'caps' => $capRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cap_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cap = new Cap();
        $form = $this->createForm(CapType::class, $cap);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Change content-type according to image's
            $imagefile = $cap->getImageFile();
            if($imagefile) {
                    $mimetype = $imagefile->getMimeType();
                    $cap->setContentType($mimetype);
            }

            $entityManager->persist($cap);
            $entityManager->flush();

            return $this->redirectToRoute('app_cap_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cap/new.html.twig', [
            'cap' => $cap,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cap_show', methods: ['GET'])]
    public function show(Cap $cap): Response
    {
        return $this->render('cap/show.html.twig', [
            'cap' => $cap,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cap_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Cap $cap, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CapType::class, $cap);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cap_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cap/edit.html.twig', [
            'cap' => $cap,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cap_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Cap $cap, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cap->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cap);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cap_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/newininventory/{id}', name: 'app_cap_newininventory', methods: ['GET', 'POST'])]
     public function newInInventory(Request $request, EntityManagerInterface $entityManager, Inventory $inventory): Response
     {
             $cap = new Cap();
             $cap->setInventory($inventory);

             $form = $this->createForm(CapType::class, $cap, ['display_inventory' => false ]);
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->persist($cap);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_inventory_show', ['id' => $inventory->getId()], Response::HTTP_SEE_OTHER);
             }

             return $this->render('cap/newininventory.html.twig', [
                     'inventory' => $inventory,
                     'cap' => $cap,
                     'form' => $form->createView(),
             ]);
     }
}
