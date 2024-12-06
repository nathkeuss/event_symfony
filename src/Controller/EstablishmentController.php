<?php

namespace App\Controller;

use App\Entity\Establishment;
use App\Form\EstablishmentType;
use App\Repository\EstablishmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EstablishmentController extends AbstractController
{
    #[Route('/establishment', name: 'app_establishment')]
    public function index(EstablishmentRepository $establishmentRepository): Response
    {
        $establishments = $establishmentRepository->findAll();

        return $this->render('establishment/index.html.twig', [
            'establishments' => $establishments,

        ]);
    }

    #[Route('/establishment/create', name: 'create_establishment')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $establishment = new Establishment();

        $establishment_form = $this->createForm(EstablishmentType::class, $establishment);

        $establishment_form->handleRequest($request);

        if ($establishment_form->isSubmitted()) {
            $entityManager->persist($establishment);
            $entityManager->flush();
            $this->addFlash('success', 'Etablissement bien créé.');
            return $this->redirectToRoute('app_establishment');
        }

        $formView = $establishment_form->createView();

        return $this->render('establishment/create_establishment.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/establishment/{id}/update', name: 'update_establishment')]
    public function updateEstablishment(int $id, Request $request, EntityManagerInterface $entityManager ,EstablishmentRepository $establishmentRepository): Response
    {
        $establishment = $establishmentRepository->find($id);

        $establishment_form = $this->createForm(EstablishmentType::class, $establishment);

        $establishment_form->handleRequest($request);

        if ($establishment_form->isSubmitted()) {
            $entityManager->persist($establishment);
            $entityManager->flush();
            return $this->redirectToRoute('app_establishment');
        }

        $formView = $establishment_form->createView();

        return $this->render('establishment/update_establishment.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/establishment/{id}', name: 'delete_establishment')]
    public function deleteEstablishment(int $id, EstablishmentRepository $establishmentRepository, EntityManagerInterface $entityManager): Response
    {
        $establishment = $establishmentRepository->find($id);

        $entityManager->remove($establishment);
        $entityManager->flush();

        return $this->redirectToRoute('app_establishment');
    }
}
