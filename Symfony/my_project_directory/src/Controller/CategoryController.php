<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFilterType;
use App\Form\CategoryForm;
use App\Repository\CategoryRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
final class CategoryController extends AbstractController
{
    #[Route(name: 'app_category_index', methods: ['GET', 'POST'])]
    public function index(Request $request, PaginationService $paginationService): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }

        $page = $request->get('page', 1);
        $itemsPerPage = $request->get('itemsPerPage', 2);

        // Форма фільтрації
        $form = $this->createForm(CategoryFilterType::class);
        $form->handleRequest($request);
        $filterData = $form->getData() ?? [];

        $categories = $paginationService->paginate(
            'App\Entity\Category',
            $filterData,  // Передаємо фільтри
            $page,
            $itemsPerPage,
            function ($queryBuilder, $filterData) {
                // Додаємо фільтри, якщо вони є
                if (isset($filterData['name']) && $filterData['name']) {
                    $queryBuilder->andWhere('e.name LIKE :name')
                        ->setParameter('name', '%' . $filterData['name'] . '%');
                }
            }
        );
        $totalCategories = $paginationService->getTotalCount(
            'App\Entity\Category',
            $filterData,
            function ($queryBuilder, $filterData) {
                if (isset($filterData['name']) && $filterData['name']) {
                    $queryBuilder->andWhere('e.name LIKE :name')
                        ->setParameter('name', '%' . $filterData['name'] . '%');
                }
            }
        );
        $totalPages = ceil($totalCategories / $itemsPerPage);

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
            'totalCategories' => $totalCategories,
        ]);
    }

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') &&
            !$this->isGranted('ROLE_MANAGER')) {
            throw $this->createAccessDeniedException();
        }

        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') &&
            !$this->isGranted('ROLE_MANAGER')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN'))
        {
            throw $this->createAccessDeniedException();
        }
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
