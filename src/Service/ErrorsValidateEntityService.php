<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ErrorsValidateEntityService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function execute(object $entity)
    {
        $messages = [];
        $errors = $this->validator->validate($entity);
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $messages[] = $violation->getMessage();
            }

            return implode(', ', $messages);
        }

        return false;
    }
}