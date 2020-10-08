<?php

namespace App\Repository;

use App\Entity\Andress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Andress|null find($id, $lockMode = null, $lockVersion = null)
 * @method Andress|null findOneBy(array $criteria, array $orderBy = null)
 * @method Andress[]    findAll()
 * @method Andress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AndressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Andress::class);
    }

    // /**
    //  * @return Andress[] Returns an array of Andress objects
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
    public function findOneBySomeField($value): ?Andress
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
