<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Exception\TeacherException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Teacher find($id, $lockMode = null, $lockVersion = null)
 * @method null|Teacher findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    use SyncEntities;
    use DeleteEntities;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    public function findTeacher(int $id): Teacher
    {
        $teacher = $this->find($id);
        if (!$teacher) {
            throw new TeacherException(
                'Esse professor não existe no sistema.',
                401
            );
        }

        return $teacher;
    }

    public function checkCpf(string $cpf): void
    {
        $result = $this->createQueryBuilder('t')
            ->andWhere('t.cpf = :cpf')
            ->setParameter('cpf', $cpf)
            ->getQuery()
            ->getResult()
        ;

        if (!empty($result)) {
            throw new TeacherException(
                'Já existe um professor com esse cpf',
                401
            );
        }
    }

    public function checkEmail(string $email): void
    {
        $result = $this->createQueryBuilder('t')
            ->andWhere('t.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult()
        ;

        if (!empty($result)) {
            throw new TeacherException(
                'Já existe um professor com esse email',
                401
            );
        }
    }

    // /**
    //  * @return Teacher[] Returns an array of Teacher objects
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
    public function findOneBySomeField($value): ?Teacher
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