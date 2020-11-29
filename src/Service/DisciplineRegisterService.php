<?php

namespace App\Service;

use App\Entity\Discipline;
use App\Exception\DisciplineException;
use App\Form\DisciplineType;
use App\Repository\DisciplineRepository;
use DateTime;
use DateTimeZone;

class DisciplineRegisterService
{
    private DisciplineRepository $disciplineRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        ErrorsValidateEntityService $errorsValidateEntityService
    ) {
        $this->disciplineRepository = $disciplineRepository;
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    public function execute(array $jsonData, $discipline = null): void
    {
        $disciplineData = FormFactory::create(
            $jsonData,
            DisciplineType::class,
            $discipline ? $discipline : new Discipline()
        );
        if ($errors = $this->errorsValidateEntityService->execute($disciplineData)) {
            throw new DisciplineException($errors, 400);
        }

        $disciplineData->setStatus(true);
        if (!$disciplineData->getCreatedAt()) {
            $disciplineData->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
        }
        $this->disciplineRepository->runSync($disciplineData);
    }
}