<?php

namespace App\Service;

use App\Entity\Discipline;
use App\Repository\DisciplineRepository;
use App\Repository\TeacherRepository;

class AddCoordinatorDisciplineService
{
    private ErrorsValidateEntityService $errorsValidateEntityService;

    private TeacherRepository $teacherRepository;

    public function __construct(
        ErrorsValidateEntityService $errorsValidateEntityService,
        TeacherRepository $teacherRepository
    ) {
        $this->errorsValidateEntityService = $errorsValidateEntityService;
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(array $jsonData, Discipline $discipline): void
    {
        $teacher = $this->teacherRepository->findTeacher($jsonData['TeacherId']);
        $teacher->setCoordinatedDisipline($discipline);
        $this->teacherRepository->runSync($teacher);
    }
}