<?php

namespace App\Service;

use Symfony\Component\Form\Forms;

class FormFactory
{
    public static function create(array $data, string $className, object $entity): object
    {
        $formFactory = Forms::createFormFactory();
        $formEntity = $formFactory->create($className, $entity);
        $formEntity->submit($data);

        return $entity;
    }
}