<?php

namespace App\Repository;

use App\Entity\Discipline;
use App\Exception\DisciplineException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Discipline find($id, $lockMode = null, $lockVersion = null)
 * @method null|Discipline findOneBy(array $criteria, array $orderBy = null)
 * @method Discipline[]    findAll()
 * @method Discipline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisciplineRepository extends ServiceEntityRepository
{
    use SyncEntities;
    use DeleteEntities;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discipline::class);
    }

    public function findDisciplines(int $id): Discipline
    {
        $discipline = $this->find($id);
        if (!$discipline) {
            throw new DisciplineException(
              'Disiplina não encontrada.',
              401
            );
        }

        return $discipline;
    }

    // /**
    //  * @return Discipline[] Returns an array of Discipline objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Discipline
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}