<?php

namespace App\Controller;

use App\Entity\Checklist;
use App\Entity\Item;
use App\Form\ChecklistType;
use App\Form\ItemType;
use App\Repository\ChecklistRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ChecklistController extends AbstractController
{
    #[Route('/')]
    public function index(ChecklistRepository $checklistRepository): Response
    {
        return $this->render('checklist/index.html.twig', [
            'checklists' => $checklistRepository->findAll(),
        ]);
    }

    #[Route('/create')]
    public function create(Request $request, ChecklistRepository $checklistRepository): Response
    {
        $checklist = new Checklist();
        $form = $this->createForm(ChecklistType::class, $checklist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $checklistRepository->save($checklist, true);

            return $this->redirectToRoute('app_checklist_index');
        }

        return $this->render('checklist/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}')]
    public function show(Request $request, Checklist $checklist, ItemRepository $itemRepository): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $item->setChecklist($checklist);

            $itemRepository->save($item, true);

            return $this->redirectToRoute('app_checklist_show', [
                'id' => $checklist->getId(),
            ]);
        }

        return $this->render('checklist/show.html.twig', [
            'checklist' => $checklist,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}')]
    public function delete(Checklist $checklist, ChecklistRepository $checklistRepository): Response
    {
        $checklistRepository->remove($checklist, true);

        return $this->redirectToRoute('app_checklist_index');
    }
}
