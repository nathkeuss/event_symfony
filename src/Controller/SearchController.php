<?php

namespace App\Controller;

use App\Repository\AnimatorRepository;
use App\Repository\CategoryRepository;
use App\Repository\EstablishmentRepository;
use App\Repository\EventRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends  AbstractController
{

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, AnimatorRepository $animatorRepository, EventRepository $eventRepository, CategoryRepository $categoryRepository, RoomRepository $roomRepository, EstablishmentRepository $establishmentRepository): Response
    {
        $search = $request->query->get('search', '');

        $rooms = $roomRepository->search($search);
        $events = $eventRepository->search($search);
        $categories = $categoryRepository->search($search);
        $establishments = $establishmentRepository->search($search);
        $animators = $animatorRepository->search($search);

        return $this->render('search_results.html.twig', [
            'search' => $search,
            'animators' => $animators,
            'rooms' => $rooms,
            'events' => $events,
            'categories' => $categories,
            'establishments' => $establishments
        ]);
    }


}