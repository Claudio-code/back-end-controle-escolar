<?php

namespace App\Service;

use App\Repository\AddressRepository;
use App\Repository\ResponsibleRepository;
use App\Repository\StudentRepository;

class StudentRegisterService
{
    private StudentRepository $studentRepository;

    private AddressRepository $addressRepository;

    private ResponsibleRepository $responsibleRepository;

    public function __construct(
        StudentRepository $studentRepository,
        AddressRepository $addressRepository,
        ResponsibleRepository $responsibleRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->addressRepository = $addressRepository;
        $this->responsibleRepository = $responsibleRepository;
    }

    public function execute(array $jsonData): void
    {
        print_r($jsonData);
        exit(1);
    }
}
