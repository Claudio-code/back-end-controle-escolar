<?php

namespace App\Repository;

use App\Entity\Responsible;
use App\Exception\ResponsibleException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Responsible find($id, $lockMode = null, $lockVersion = null)
 * @method null|Responsible findOneBy(array $criteria, array $orderBy = null)
 * @method Responsible[]    findAll()
 * @method Responsible[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsibleRepository extends ServiceEntityRepository
{
    use SyncEntities;
    use DeleteEntities;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Responsible::class);
    }

    public function checkCpf(string $cpf): void
    {
        $result = $this->createQueryBuilder('r')
            ->andWhere('r.cpf = :cpf')
            ->setParameter('cpf', $cpf)
            ->getQuery()
            ->getResult()
        ;

        if (!empty($result)) {
            throw new ResponsibleException(
                'Já existe um responsavel com esse cpf',
                401
            );
        }
    }

    public function checkEmail(string $email): void
    {
        $result = $this->createQueryBuilder('r')
            ->andWhere('r.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult()
        ;

        if (!empty($result)) {
            throw new ResponsibleException(
                'Já existe um responsavel com esse email',
                401
            );
        }
    }

    // /**
    //  * @return Responsible[] Returns an array of Responsible objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Responsible
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}