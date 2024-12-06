<?php

namespace App\Controller;

use App\Entity\Animator;
use App\Form\AnimatorType;
use App\Repository\AnimatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimatorController extends AbstractController
{
    #[Route('/animator', name: 'app_animator')]
    public function index(AnimatorRepository $animatorRepository): Response
    {
        $animators = $animatorRepository->findAll();

        return $this->render('animator/index.html.twig', [
            'animators' => $animators,
        ]);
    }

    #[Route('/animator/create', name: 'create_animator')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $animator = new Animator();

        $animator_form = $this->createForm(AnimatorType::class, $animator);

        $animator_form->handleRequest($request);

        if ($animator_form->isSubmitted()) {
            $entityManager->persist($animator);
            $entityManager->flush();
            $this->addFlash('success', 'Animateur bien ajouté.');
            return $this->redirectToRoute('app_animator');
        }

        $formView = $animator_form->createView();

        return $this->render('animator/create_animator.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/animator/{id}/update', name: 'update_animator')]
    public function updateAnimator(int $id, Request $request, EntityManagerInterface $entityManager , AnimatorRepository $animatorRepository): Response
    {
        $animator = $animatorRepository->find($id);

        $animator_form = $this->createForm(AnimatorType::class, $animator);

        $animator_form->handleRequest($request);

        if ($animator_form->isSubmitted()) {
            $entityManager->persist($animator);
            $entityManager->flush();
            return $this->redirectToRoute('app_animator');
        }

        $formView = $animator_form->createView();

        return $this->render('animator/update_animator.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/animator/{id}', name: 'delete_animator')]
    public function deleteEstablishment(int $id, AnimatorRepository $animatorRepository, EntityManagerInterface $entityManager): Response
    {
        $animator = $animatorRepository->find($id);

        $entityManager->remove($animator);
        $entityManager->flush();

        return $this->redirectToRoute('app_animator');
    }
}
