<?php

namespace App\Service;

use App\Entity\Discipline;
use App\Exception\DisciplineException;
use App\Form\DisciplineType;
use App\Repository\DisciplineRepository;
use App\Repository\TeacherRepository;
use App\Repository\TopicsRepository;
use DateTime;
use DateTimeZone;

class DisciplineRegisterService
{
    private TopicsRepository $topicsRepository;

    private TeacherRepository $teacherRepository;

    private DisciplineRepository $disciplineRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(
        TopicsRepository $topicsRepository,
        TeacherRepository $teacherRepository,
        DisciplineRepository $disciplineRepository,
        ErrorsValidateEntityService $errorsValidateEntityService
    ) {
        $this->disciplineRepository = $disciplineRepository;
        $this->topicsRepository = $topicsRepository;
        $this->teacherRepository = $teacherRepository;
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