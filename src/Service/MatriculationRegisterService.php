<?php

namespace App\Service;

use App\Entity\Matriculation;
use App\Exception\MatriculationException;
use App\Form\MatriculationType;
use App\Repository\ClassesRepository;
use App\Repository\MatriculationRepository;
use App\Repository\StudentRepository;

class MatriculationRegisterService
{
    private StudentRepository $studentRepository;
    
    private ClassesRepository $classesRepository;
    
    private MatriculationRepository $matriculationRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;
    
    public function __construct(
        StudentRepository $studentRepository,
        ClassesRepository $classesRepository,
        ErrorsValidateEntityService $errorsValidateEntityService,
        MatriculationRepository $matriculationRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->classesRepository = $classesRepository;
        $this->matriculationRepository = $matriculationRepository;
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    public function execute(array $jsonData, ?Matriculation $matriculation = null): void
    {
        $matriculationData = FormFactory::create(
            $jsonData,
            MatriculationType::class,
            $matriculation ? $matriculation : new Matriculation()
        );
        if ($errors = $this->errorsValidateEntityService->execute($matriculationData)) {
            throw new MatriculationException($errors, 400);
        }
        
        $student = $this->studentRepository->findStudent(intval($jsonData['StudentId']));
        $classe = $this->classesRepository->findClasse(intval($jsonData['ClasseId']));

        $matriculationData->setClasse($classe);
        $matriculationData->setStudent($student);
        if (!$matriculationData->getCreatedAt()) {
            $matriculationData->setCreatedAt(
                new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'))
            );
        }
        
        $this->matriculationRepository->runSync($matriculationData);
    }
}