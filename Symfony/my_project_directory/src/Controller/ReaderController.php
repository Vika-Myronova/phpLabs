<?php

namespace App\Controller;

use App\Entity\Reader;
use App\Form\ReaderFilterType;
use App\Form\ReaderForm;
use App\Repository\ReaderRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reader')]
final class ReaderController extends AbstractController
{
    #[Route(name: 'app_reader_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        ReaderRepository $readerRepository,
        PaginationService $paginationService
    ): Response {
        // Параметри пагінації
        $page = $request->get('page', 1);  // За замовчуванням сторінка 1
        $itemsPerPage = $request->get('itemsPerPage', 10);  // За замовчуванням 10 елементів на сторінці

        // Форма фільтрації
        $form = $this->createForm(ReaderFilterType::class);
        $form->handleRequest($request);

        // Отримуємо фільтри у вигляді масиву
        $filters = $form->getData();

        // Переконуємося, що фільтри це масив
        if (!is_array($filters)) {
            $filters = [];
        }

        // Передаємо фільтри в paginate
        $readers = $paginationService->paginate(
            'App\Entity\Reader',  // сутність
            $filters,  // передаємо масив фільтрів
            $page,
            $itemsPerPage,
            function ($queryBuilder, $filters) {
                // Додаємо фільтри до запиту
                if (isset($filters['fullName']) && $filters['fullName']) {
                    $queryBuilder->andWhere('e.fullName LIKE :fullName')
                        ->setParameter('fullName', '%' . $filters['fullName'] . '%');
                }
                if (isset($filters['email']) && $filters['email']) {
                    $queryBuilder->andWhere('e.email LIKE :email')
                        ->setParameter('email', '%' . $filters['email'] . '%');
                }
            }
        );

        // Загальна кількість читачів для пагінації
        $totalReaders = $paginationService->getTotalCount(
            'App\Entity\Reader',
            $filters,
            function ($queryBuilder, $filters) {
                if (isset($filters['fullName']) && $filters['fullName']) {
                    $queryBuilder->andWhere('e.fullName LIKE :fullName')
                        ->setParameter('fullName', '%' . $filters['fullName'] . '%');
                }
                if (isset($filters['email']) && $filters['email']) {
                    $queryBuilder->andWhere('e.email LIKE :email')
                        ->setParameter('email', '%' . $filters['email'] . '%');
                }
            }
        );

        // Розраховуємо кількість сторінок
        $totalPages = ceil($totalReaders / $itemsPerPage);

        return $this->render('reader/index.html.twig', [
            'form' => $form->createView(),
            'readers' => $readers,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'itemsPerPage' => $itemsPerPage,
            'totalReaders' => $totalReaders,
        ]);
    }

    #[Route('/new', name: 'app_reader_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reader = new Reader();
        $form = $this->createForm(ReaderForm::class, $reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reader);
            $entityManager->flush();

            return $this->redirectToRoute('app_reader_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reader/new.html.twig', [
            'reader' => $reader,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reader_show', methods: ['GET'])]
    public function show(Reader $reader): Response
    {
        return $this->render('reader/show.html.twig', [
            'reader' => $reader,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reader_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reader $reader, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReaderForm::class, $reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reader_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reader/edit.html.twig', [
            'reader' => $reader,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reader_delete', methods: ['POST'])]
    public function delete(Request $request, Reader $reader, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reader->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reader);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reader_index', [], Response::HTTP_SEE_OTHER);
    }
}
