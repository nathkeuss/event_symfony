<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/create', name: 'create_category')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();

        $category_form = $this->createForm(CategoryType::class, $category);

        $category_form->handleRequest($request);

        if ($category_form->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category');
        }

        $formView = $category_form->createView();

        return $this->render('category/create_category.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/category/{id}/update', name: 'update_category')]
    public function updateCategory(int $id, Request $request, EntityManagerInterface $entityManager , CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        $category_form = $this->createForm(Category::class, $category);

        $category_form->handleRequest($request);

        if ($category_form->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('app_category');
        }

        $formView = $category_form->createView();

        return $this->render('category/update_category.html.twig', [
            'formView' => $formView,
        ]);
    }

    #[Route('/category/{id}', name: 'delete_category')]
    public function deleteCategory(int $id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager): Response
    {
        $category = $categoryRepository->find($id);

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('app_category');
    }
}
