<?php

namespace App\Service;

use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Repository\TeacherRepository;

class AddCoordinatorCourseService
{
    private TeacherRepository $teacherRepository;

    private CourseRepository $courseRepository;

    public function __construct(
        TeacherRepository $teacherRepository,
        CourseRepository $courseRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function execute(int $teacherId, Course $course): void
    {
        $teacher = $this->teacherRepository->findTeacher($teacherId);
        $course->setCoordinator($teacher);
        $this->courseRepository->runSync($course);
    }
}