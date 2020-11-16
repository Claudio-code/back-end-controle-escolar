<?php

namespace App\Service;

use App\Repository\DisciplineRepository;
use App\Repository\TeacherRepository;
use App\Repository\TopicsRepository;

class DisciplineRegisterService
{
    private TopicsRepository $topicsRepository;

    private TeacherRepository $teacherRepository;

    private DisciplineRepository $disciplineRepository;

    public function __construct(
        TopicsRepository $topicsRepository,
        TeacherRepository $teacherRepository,
        DisciplineRepository $disciplineRepository
    ) {
        $this->disciplineRepository = $disciplineRepository;
        $this->topicsRepository = $topicsRepository;
        $this->teacherRepository = $teacherRepository;
    }
}