<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/item')]
class ItemController extends AbstractController
{
    #[Route('/delete/{id}')]
    public function delete(Item $item, ItemRepository $itemRepository): Response
    {
        $itemRepository->remove($item, true);

        return $this->redirectToRoute('app_checklist_index');
    }
}
