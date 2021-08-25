<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    // /**
    //  * @return Address[] Returns an array of Address objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Address
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByKeyword($keyword,$column,$order)
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('s')
            ->where('s.id LIKE :keyword')
            //anrede samllint -> search as text
            ->orWhere("(:inputkeyword = 'prof' OR :inputkeyword = 'prof.') AND s.anrede = 3")
            ->orWhere("(:inputkeyword = 'dr' OR :inputkeyword = 'dr.') AND s.anrede = 2")
            ->orWhere(":inputkeyword = 'frau' AND s.anrede = 1")
            ->orWhere(":inputkeyword = 'herr' AND s.anrede = 0")
            
            ->orWhere('s.vorname LIKE :keyword')
            ->orWhere('s.nachname LIKE :keyword')
            ->orWhere('s.strasse LIKE :keyword')   
            ->orWhere('s.hausnummer LIKE :keyword')
            ->orWhere('s.plz LIKE :keyword')
            ->orWhere('s.ort LIKE :keyword')   
            ->orWhere('s.email LIKE :keyword')
            ->orWhere('s.telefon LIKE :keyword')
            ->orWhere('s.geburtsdatum LIKE :keyword')
            ->orderBy('s.'.$column, $order)
            ->setParameter('inputkeyword',$keyword)
            ->setParameter('keyword', '%'.$keyword.'%');    
            

        return $query = $qb->getQuery()->getResult();//?null

//        return $query->execute();

        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }
}
