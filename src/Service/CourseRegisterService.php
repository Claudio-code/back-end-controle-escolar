<?php

namespace App\Service;


use App\Entity\Course;
use App\Exception\CourseException;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use DateTime;
use DateTimeZone;

class CourseRegisterService
{
    private CourseRepository $courseRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(
        ErrorsValidateEntityService $errorsValidateEntityService,
        CourseRepository $courseRepository
    ) {
        $this->courseRepository = $courseRepository;
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
        $this->courseRepository->runSync($courseData);
    }
}