<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/event/create', name: 'create_event')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $event = new Event();

        $event_form = $this->createForm(EventType::class, $event);

        $event_form->handleRequest($request);

        if ($event_form->isSubmitted()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event');
        }

        $formView = $event_form->createView();

        return $this->render('event/create_event.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/event/{id}/update', name: 'update_event')]
    public function updateEvent(int $id, Request $request, EntityManagerInterface $entityManager , EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        $event_form = $this->createForm(EventType::class, $event);

        $event_form->handleRequest($request);

        if ($event_form->isSubmitted()) {
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('app_event');
        }

        $formView = $event_form->createView();

        return $this->render('event/update_event.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/event/{id}', name: 'delete_event')]
    public function deleteEvent(int $id, EventRepository $eventRepository, EntityManagerInterface $entityManager): Response
    {
        $event = $eventRepository->find($id);

        $entityManager->remove($event);
        $entityManager->flush();

        return $this->redirectToRoute('app_event');
    }
}
