<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class PaginationService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Пагінація для будь-якої сутності з фільтрами
     * @param string $entityClass - клас сутності, для якої буде виконуватися запит
     * @param array $filterData - фільтри для запиту
     * @param int $page - номер сторінки
     * @param int $itemsPerPage - кількість елементів на сторінці
     * @param callable|null $filterCallback - додаткові фільтри для кастомізації запиту
     * @return array - результати запиту
     */
    public function paginate(string $entityClass, array $filterData, int $page = 1, int $itemsPerPage = 10, callable $filterCallback = null)
    {
        // Створюємо query builder для запиту до сутності
        $queryBuilder = $this->em->getRepository($entityClass)->createQueryBuilder('e');

        // Додаємо фільтри через callback, якщо він переданий
        if ($filterCallback) {
            $filterCallback($queryBuilder, $filterData);
        }

        // Пагінація
        $queryBuilder->setFirstResult(($page - 1) * $itemsPerPage)  // Встановлюємо перший результат
        ->setMaxResults($itemsPerPage);  // Встановлюємо максимальну кількість елементів на сторінці

        // Отримуємо результати
        $results = $queryBuilder->getQuery()->getResult();

        return $results;
    }

    /**
     * Отримуємо загальну кількість записів
     */
    public function getTotalCount(string $entityClass, array $filterData, callable $filterCallback = null)
    {
        $queryBuilder = $this->em->getRepository($entityClass)->createQueryBuilder('e');

        if ($filterCallback) {
            $filterCallback($queryBuilder, $filterData);
        }

        return (int) $queryBuilder->select('COUNT(e.id)')  // Підрахунок загальної кількості
        ->getQuery()
            ->getSingleScalarResult();
    }

}