<?php

namespace App\Service;

use App\Entity\Responsible;
use App\Exception\StudentException;
use App\Form\ResponsibleType;
use App\Repository\ResponsibleRepository;
use App\Repository\StudentRepository;
use DateTime;
use DateTimeZone;

class ResponsibleRegisterService
{
    private StudentRepository $studentRepository;

    private ResponsibleRepository $responsibleRepository;

    public function __construct(
        StudentRepository $studentRepository,
        ResponsibleRepository $responsibleRepository
    ) {
        $this->responsibleRepository = $responsibleRepository;
        $this->studentRepository = $studentRepository;
    }

    public function execute(array $jsonData, $responsible = null): void
    {
        $student = $this->studentRepository->find($jsonData['student_id']);

        if (!array_key_exists('student_id', $jsonData)) {
            throw new StudentException(
                'Não foi enviado o estudante para poder cadastrar o endereço.',
                401
            );
        }
        if (!$student) {
            throw new StudentException(
                'O estudante enviado não existe.',
                402
            );
        }
        if (!$responsible) {
            $responsible = new Responsible();
        }

        $responsible = FormFactory::create($jsonData, ResponsibleType::class, $responsible);
        $responsible->setStudent($student);
        if (!$responsible->getCreatedAt()) {
            $responsible->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
        }

        $this->responsibleRepository->runSync($responsible);
    }
}