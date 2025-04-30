<?php

namespace App\Controller;

use App\Entity\Borrowing;
use App\Form\BorrowingFilterType;
use App\Form\BorrowingForm;
use App\Repository\BorrowingRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/borrowing')]
final class BorrowingController extends AbstractController
{
    #[Route(name: 'app_borrowing_index', methods: ['GET', 'POST'])]
    public function index(Request $request,
                          BorrowingRepository $borrowingRepository,
                          PaginationService $paginationService): Response
    {
        $page = $request->get('page', 1);
        $itemsPerPage = $request->get('itemsPerPage', 2);

        $form = $this->createForm(BorrowingFilterType::class);
        $form->handleRequest($request);
        $filters = $form->getData() ?? [];

        $borrowings = $paginationService->paginate(
            'App\Entity\Borrowing',
            $filters,
            $page,
            $itemsPerPage,
            function ($queryBuilder, $filters) {
                if (isset($filters['book']) && $filters['book']) {
                    $queryBuilder->andWhere('e.book = :book')
                        ->setParameter('book', $filters['book']);
                }
                if (isset($filters['borrower']) && $filters['borrower']) {
                    $queryBuilder->andWhere('e.borrower = :borrower')
                        ->setParameter('borrower', $filters['borrower']);
                }
                if (isset($filters['borrowedAt']) && $filters['borrowedAt']) {
                    $queryBuilder->andWhere('e.borrowedAt >= :borrowedAt')
                        ->setParameter('borrowedAt', $filters['borrowedAt']);
                }
            }
        );

        $totalBorrowings = $paginationService->getTotalCount(
            'App\Entity\Borrowing',
            $filters,
            function ($queryBuilder, $filters) {
                if (isset($filters['book']) && $filters['book']) {
                    $queryBuilder->andWhere('e.book = :book')
                        ->setParameter('book', $filters['book']);
                }
                if (isset($filters['borrower']) && $filters['borrower']) {
                    $queryBuilder->andWhere('e.borrower = :borrower')
                        ->setParameter('borrower', $filters['borrower']);
                }
                if (isset($filters['borrowedAt']) && $filters['borrowedAt']) {
                    $queryBuilder->andWhere('e.borrowedAt >= :borrowedAt')
                        ->setParameter('borrowedAt', $filters['borrowedAt']);
                }
            }
        );
        $totalPages = ceil($totalBorrowings / $itemsPerPage);

        return $this->render('borrowing/index.html.twig', [
            'form' => $form->createView(),
            'borrowings' => $borrowings,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
            'totalBorrowings' => $totalBorrowings,
        ]);
    }

    #[Route('/new', name: 'app_borrowing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $borrowing = new Borrowing();
        $form = $this->createForm(BorrowingForm::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($borrowing);
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowings/new.html.twig', [
            'borrowings' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrowing_show', methods: ['GET'])]
    public function show(Borrowing $borrowing): Response
    {
        return $this->render('borrowings/show.html.twig', [
            'borrowings' => $borrowing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_borrowing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowingForm::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowings/edit.html.twig', [
            'borrowings' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrowing_delete', methods: ['POST'])]
    public function delete(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrowing->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($borrowing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
    }
}
