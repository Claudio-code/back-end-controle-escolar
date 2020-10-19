<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\Responsible;
use App\Entity\Student;
use App\Exception\AddressException;
use App\Exception\ResponsibleException;
use App\Exception\StudentException;
use App\Form\AddressType;
use App\Form\ResponsibleType;
use App\Form\StudentType;
use App\Repository\AddressRepository;
use App\Repository\ResponsibleRepository;
use App\Repository\StudentRepository;
use DateTime;
use DateTimeZone;

class StudentRegisterService
{
    private StudentRepository $studentRepository;

    private AddressRepository $addressRepository;

    private ResponsibleRepository $responsibleRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(
        StudentRepository $studentRepository,
        AddressRepository $addressRepository,
        ResponsibleRepository $responsibleRepository,
        ErrorsValidateEntityService $errorsValidateEntityService
    ) {
        $this->studentRepository = $studentRepository;
        $this->addressRepository = $addressRepository;
        $this->responsibleRepository = $responsibleRepository;
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    public function execute(array $jsonData): void
    {
        $student = FormFactory::create($jsonData, StudentType::class, new Student());

        if ($errors = $this->errorsValidateEntityService->execute($student)) {
            throw new StudentException($errors, 400);
        }

        $student->setStatus(true);
        $student->setCreatedAt(
            new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
        );

        $student = $this->studentRepository->runSync($student);

        if (array_key_exists('Address', $jsonData)) {
            $address = FormFactory::create($jsonData['Address'], AddressType::class, new Address());

            if ($errors = $this->errorsValidateEntityService->execute($address)) {
                throw new AddressException($errors, 400);
            }

            $address->setStudent($student);
            $address->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
            $this->addressRepository->runSync($address);
        }

        if (array_key_exists('Responsible', $jsonData)) {
            $responsible = FormFactory::create($jsonData['Responsible'], ResponsibleType::class, new Responsible());

            if ($errors = $this->errorsValidateEntityService->execute($responsible)) {
                throw new ResponsibleException($errors, 400);
            }

            $responsible->setStudent($student);
            $responsible->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
            $this->responsibleRepository->runSync($responsible);
        }
    }
}
