<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'app_room')]
    public function index(RoomRepository $roomRepository): Response
    {
        $rooms = $roomRepository->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/room/create', name: 'create_room')]
    public function create(EntityManagerInterface  $entityManager, Request $request): Response
    {
        $room = new Room();

        $room_form = $this->createForm(RoomType::class, $room);

        $room_form->handleRequest($request);

        if ($room_form->isSubmitted()) {
            $entityManager->persist($room);
            $entityManager->flush();
            $this->addFlash('success', 'Salle bien créée.');
            return $this->redirectToRoute('app_establishment');
        }

        $formView = $room_form->createView();

        return $this->render('room/create_room.html.twig', [
            'formView' => $formView,
        ]);
    }


    #[Route('/room/{id}/update', name: 'update_room')]
    public function updateRoom(int $id, Request $request, EntityManagerInterface $entityManager , RoomRepository $roomRepository): Response
    {
        $room = $roomRepository->find($id);

        $room_form = $this->createForm(RoomType::class, $room);

        $room_form->handleRequest($request);

        if ($room_form->isSubmitted()) {
            $entityManager->persist($room);
            $entityManager->flush();
            return $this->redirectToRoute('app_room');
        }

        $formView = $room_form->createView();

        return $this->render('room/update_room.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/room/{id}', name: 'delete_room')]
    public function deleteRoom(int $id, RoomRepository $roomRepository, EntityManagerInterface $entityManager): Response
    {
        $room = $roomRepository->find($id);

        $entityManager->remove($room);
        $entityManager->flush();

        return $this->redirectToRoute('app_room');
    }

}
