<?php

namespace App\Service;

use App\Entity\Classes;
use App\Exception\ClassesException;
use App\Form\ClassesType;
use App\Repository\ClassesRepository;
use DateTime;
use DateTimeZone;

class ClasseRegisterService
{
    private ErrorsValidateEntityService $errorsValidateEntityService;

    private ClassesRepository $classesRepository;

    public function __construct(
        ErrorsValidateEntityService $errorsValidateEntityService,
        ClassesRepository $classesRepository
    ) {
        $this->classesRepository = $classesRepository;
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    public function execute(array $jsonData, ?Classes $classese = null): void
    {
        $classeData = FormFactory::create(
            $jsonData,
            ClassesType::class,
            $classese ? $classese : new Classes()
        );
        if ($errors = $this->errorsValidateEntityService->execute($classeData)) {
            throw new ClassesException($errors, 400);
        }
        if (!$classeData->getCreatedAt()) {
            $classeData->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
        }

        $this->classesRepository->runSync($classeData);
    }
}