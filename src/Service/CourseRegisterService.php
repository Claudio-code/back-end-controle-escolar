<?php

namespace App\Service;


use App\Entity\Course;
use App\Exception\CourseException;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Repository\DisciplineRepository;
use DateTime;
use DateTimeZone;

class CourseRegisterService
{
    private CourseRepository $courseRepository;

    private DisciplineRepository $disciplineRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(
        ErrorsValidateEntityService $errorsValidateEntityService,
        CourseRepository $courseRepository,
        DisciplineRepository $disciplineRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    public function execute(array $jsonData, ?Course $course = null): void
    {
        $courseData = FormFactory::create(
            $jsonData,
            CourseType::class,
            $course ? $course : new Course()
        );
        if ($errors = $this->errorsValidateEntityService->execute($courseData)) {
            throw new CourseException($errors, 400);
        }
        if (!$courseData->getCreatedAt()) {
            $courseData->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
        }
        if (array_key_exists('disciplines', $jsonData)) {
            $disciplines = $jsonData['disciplines'];

            foreach ($disciplines as $value) {
                $discipline = $this->disciplineRepository->findDisciplines($value);
                $courseData->addDiscipline($discipline);
            }

        }
        $this->courseRepository->runSync($courseData);
    }
}