<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFilterType;
use App\Form\AuthorForm;
use App\Repository\AuthorRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/api/author')]
final class AuthorController extends AbstractController
{
    #[Route(name: 'app_author_index', methods: ['GET', 'POST'])]
    public function index(Request $request,
                          AuthorRepository $authorRepository,
                          PaginationService $paginationService): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }

        $page = $request->get('page', 1);
        $itemsPerPage = $request->get('itemsPerPage', 2);

        $form = $this->createForm(AuthorFilterType::class);
        $form->handleRequest($request);
        $filters = $form->getData() ?? [];

        $authors = $paginationService->paginate(
            'App\Entity\Author',
            $filters,
            $page,
            $itemsPerPage,
            function ($queryBuilder, $filters) {
                if (isset($filters['name']) && $filters['name']) {
                    $queryBuilder->andWhere('e.name LIKE :name')
                        ->setParameter('name', '%' . $filters['name'] . '%');
                }
                if (isset($filters['birth_year']) && $filters['birth_year']) {
                    $queryBuilder->andWhere('e.birthYear = :birth_year')
                        ->setParameter('birth_year', $filters['birth_year']);
                }
            }
        );

        $totalAuthors = $paginationService->getTotalCount(
            'App\Entity\Author',
            $filters,
            function ($queryBuilder, $filters) {
                if (isset($filters['name']) && $filters['name']) {
                    $queryBuilder->andWhere('e.name LIKE :name')
                        ->setParameter('name', '%' . $filters['name'] . '%');
                }
                if (isset($filters['birth_year']) && $filters['birth_year']) {
                    $queryBuilder->andWhere('e.birthYear = :birth_year')
                        ->setParameter('birth_year', $filters['birth_year']);
                }
            }
        );

        $totalPages = ceil($totalAuthors / $itemsPerPage);

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
            'form' => $form->createView(),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
            'totalAuthors' => $totalAuthors,
        ]);
    }

    #[Route('/new', name: 'app_author_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') &&
            !$this->isGranted('ROLE_MANAGER')) {
            throw $this->createAccessDeniedException();
        }

        $author = new Author();
        $form = $this->createForm(AuthorForm::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('app_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_author_show', methods: ['GET'])]
    public function show(Author $author): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_author_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Author $author, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authChecker): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') &&
            !$this->isGranted('ROLE_MANAGER')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(AuthorForm::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_author_delete', methods: ['POST'])]
    public function delete(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN'))
        {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_author_index', [], Response::HTTP_SEE_OTHER);
    }
}
