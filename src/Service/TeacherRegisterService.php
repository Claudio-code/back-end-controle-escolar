<?php

namespace App\Service;

use App\Entity\Teacher;
use App\Exception\TeacherException;
use App\Form\TeacherFormType;
use App\Repository\DisciplineRepository;
use App\Repository\TeacherRepository;
use DateTime;
use DateTimeZone;

class TeacherRegisterService
{
    private DisciplineRepository $disciplineRepository;

    private TeacherRepository $teacherRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        TeacherRepository $teacherRepository,
        ErrorsValidateEntityService $errorsValidateEntityService
    ) {
        $this->teacherRepository = $teacherRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    public function execute(array $jsonData, ?Teacher $teacher = null): void
    {
        if (!$teacher) {
            $teacher = FormFactory::create(
                $jsonData,
                TeacherFormType::class,
                new Teacher()
            );
        } else {
            $teacher = FormFactory::create(
                $jsonData,
                TeacherFormType::class,
                $teacher
            );
        }
        if ($errors = $this->errorsValidateEntityService->execute($teacher)) {
            throw new TeacherException($errors, 400);
        }

        $teacher->setStatus(true);
        if (!$teacher->getCreatedAt()) {
            $teacher->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
        }
        $this->teacherRepository->runSync($teacher);
    }
}