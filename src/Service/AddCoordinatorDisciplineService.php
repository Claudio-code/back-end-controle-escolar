<?php

namespace App\Service;

use App\Entity\Discipline;
use App\Repository\DisciplineRepository;
use App\Repository\TeacherRepository;

class AddCoordinatorDisciplineService
{
    private ErrorsValidateEntityService $errorsValidateEntityService;

    private TeacherRepository $teacherRepository;

    private DisciplineRepository $disciplineRepository;

    public function __construct(
        ErrorsValidateEntityService $errorsValidateEntityService,
        DisciplineRepository $disciplineRepository,
        TeacherRepository $teacherRepository
    ) {
        $this->errorsValidateEntityService = $errorsValidateEntityService;
        $this->disciplineRepository = $disciplineRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(array $jsonData, Discipline $discipline): void
    {
        $teacher = $this->teacherRepository->findTeacher(intval($jsonData['TeacherId']));
        $discipline->setCoordinator($teacher);
        $this->disciplineRepository->runSync($discipline);
    }
}