<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookFilterType;
use App\Form\BookForm;
use App\Repository\BookRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
final class BookController extends AbstractController
{
    #[Route(name: 'app_book_index', methods: ['GET', 'POST'])]
    public function index(Request $request,
                          BookRepository $bookRepository,
                          PaginationService $paginationService): Response
    {
        $page = $request->get('page', 1);
        $itemsPerPage = $request->get('itemsPerPage', 2);

        $form = $this->createForm(BookFilterType::class);
        $form->handleRequest($request);
        $filters = $form->getData() ?? [];

        $books = $paginationService->paginate(
            'App\Entity\Book',
            $filters,
            $page,
            $itemsPerPage,
            function ($queryBuilder, $filters) {
                if (isset($filters['title']) && $filters['title']) {
                    $queryBuilder->andWhere('e.title LIKE :title')
                        ->setParameter('title', '%' . $filters['title'] . '%');
                }
                if (isset($filters['publishedYear']) && $filters['publishedYear']) {
                    $queryBuilder->andWhere('e.publishedYear = :publishedYear')
                        ->setParameter('publishedYear', $filters['publishedYear']);
                }
                if (isset($filters['author']) && $filters['author']) {
                    $queryBuilder->andWhere('e.author = :author')
                        ->setParameter('author', $filters['author']);
                }
            }
        );

        $totalBooks = $paginationService->getTotalCount(
            'App\Entity\Book',
            $filters,
            function ($queryBuilder, $filters) {
                if (isset($filters['title']) && $filters['title']) {
                    $queryBuilder->andWhere('e.title LIKE :title')
                        ->setParameter('title', '%' . $filters['title'] . '%');
                }
                if (isset($filters['publishedYear']) && $filters['publishedYear']) {
                    $queryBuilder->andWhere('e.publishedYear = :publishedYear')
                        ->setParameter('publishedYear', $filters['publishedYear']);
                }
                if (isset($filters['author']) && $filters['author']) {
                    $queryBuilder->andWhere('e.author = :author')
                        ->setParameter('author', $filters['author']);
                }
            }
        );
        $totalPages = ceil($totalBooks / $itemsPerPage);

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'form' => $form->createView(),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
            'totalBooks' => $totalBooks,
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
