<?php

namespace App\Controller;

use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ErrorsValidateEntity
{
    private function validate(ValidatorInterface $validator, DoctrineType $entity)
    {
        $messages = [];
        $errors = $validator->validate($entity);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $messages[] = $violation->getMessage();
            }

            return $messages;
        }

        return false;
    }
}
