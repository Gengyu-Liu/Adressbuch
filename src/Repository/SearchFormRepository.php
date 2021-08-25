<?php

namespace App\Repository;

use App\Entity\SearchForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchForm[]    findAll()
 * @method SearchForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchForm::class);
    }

    // /**
    //  * @return SearchForm[] Returns an array of SearchForm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchForm
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
