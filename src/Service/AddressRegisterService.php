<?php

namespace App\Service;


use App\Entity\Address;
use App\Exception\StudentException;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Repository\StudentRepository;
use DateTime;
use DateTimeZone;

class AddressRegisterService
{
    private AddressRepository $addressRepository;

    private StudentRepository $studentRepository;

    public function __construct(
        AddressRepository $addressRepository,
        StudentRepository $studentRepository
    ) {
        $this->addressRepository = $addressRepository;
        $this->studentRepository = $studentRepository;
    }

    public function execute(array $jsonData, $address = null): void
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
        if (!$address) {
            $address = new Address();
        }

        $address = FormFactory::create($jsonData, AddressType::class, $address);
        $address->setStudent($student);
        if (!$address->getCreatedAt()) {
            $address->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
        }

        $this->addressRepository->runSync($address);
    }

}