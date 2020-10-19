<?php

namespace App\Repository;

use DateTime;
use DateTimeZone;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;

trait SyncEntities
{
    public function runSync(DoctrineType $doctrineEntity): DoctrineType
    {
        $doctrineEntity->setUpdatedAt(
            new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
        );

        $this->getEntityManager()->persist($doctrineEntity);
        $this->getEntityManager()->flush();

        return $doctrineEntity;
    }
}
