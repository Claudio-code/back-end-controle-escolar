<?php

namespace App\Repository;

use App\Entity\Student;
use App\Exception\StudentException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Student find($id, $lockMode = null, $lockVersion = null)
 * @method null|Student findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    use SyncEntities;
    use DeleteEntities;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findStudent(int $id): Student
    {
        $student = $this->find($id);
        if (!$student) {
            throw new StudentException(
                'Estudante não encontrada.',
                401
            );
        }

        return $student;
    }

    public function checkCpf(string $cpf): void
    {
        $result = $this->createQueryBuilder('s')
            ->andWhere('s.cpf = :cpf')
            ->setParameter('cpf', $cpf)
            ->getQuery()
            ->getResult()
        ;

        if (!empty($result)) {
            throw new StudentException(
                'Já existe um estudante com esse cpf',
                401
            );
        }
    }

    public function checkEmail(string $email): void
    {
        $result = $this->createQueryBuilder('s')
            ->andWhere('s.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult()
        ;

        if (!empty($result)) {
            throw new StudentException(
                'Já existe um estudante com esse email',
                401
            );
        }
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
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
    public function findOneBySomeField($value): ?Student
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