<?php

namespace App\Repository;

use App\Entity\Theacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Theacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theacher[]    findAll()
 * @method Theacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theacher::class);
    }

    // /**
    //  * @return Theacher[] Returns an array of Theacher objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Theacher
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
