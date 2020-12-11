<?php

namespace App\Service;

use App\Entity\Classes;
use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Repository\ClassesRepository;

class AddClasseCourseService
{
    private ClassesRepository $classesRepository;

    private CourseRepository $courseRepository;

    public function __construct(
        CourseRepository $courseRepository,
        ClassesRepository $classesRepository
    ) {
        $this->classesRepository = $classesRepository;
        $this->courseRepository = $courseRepository;
    }

    public function execute(int $courseId, Classes $classes): void
    {
        $course = $this->courseRepository->findCourse($courseId);
        $classes->setCourse($course);
        $this->classesRepository->runSync($classes);
    }
}