<?php

namespace App\Repository;

use App\Entity\Borrowing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Borrowing>
 */
class BorrowingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrowing::class);
    }

    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('b');

        if (!empty($filters['borrowDateFrom'])) {
            $qb->andWhere('b.borrowDate >= :borrowDateFrom')
                ->setParameter('borrowDateFrom', $filters['borrowDateFrom']);
        }

        if (!empty($filters['borrowDateTo'])) {
            $qb->andWhere('b.borrowDate <= :borrowDateTo')
                ->setParameter('borrowDateTo', $filters['borrowDateTo']);
        }

        if (!empty($filters['returnDateFrom'])) {
            $qb->andWhere('b.returnDate >= :returnDateFrom')
                ->setParameter('returnDateFrom', $filters['returnDateFrom']);
        }

        if (!empty($filters['returnDateTo'])) {
            $qb->andWhere('b.returnDate <= :returnDateTo')
                ->setParameter('returnDateTo', $filters['returnDateTo']);
        }

        if (!empty($filters['book'])) {
            $qb->andWhere('b.book = :book')
                ->setParameter('book', $filters['book']);
        }

        if (!empty($filters['reader'])) {
            $qb->andWhere('b.reader = :reader')
                ->setParameter('reader', $filters['reader']);
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Borrowing[] Returns an array of Borrowing objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Borrowing
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
