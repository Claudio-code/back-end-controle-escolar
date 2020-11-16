<?php

namespace App\Service;

use App\Entity\Topics;
use App\Exception\TopicsException;
use App\Form\TopicsType;
use App\Repository\DisciplineRepository;
use App\Repository\TopicsRepository;
use DateTime;
use DateTimeZone;

class TopicsRegisterService
{
    private TopicsRepository $topicsRepository;

    private DisciplineRepository $disciplineRepository;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        TopicsRepository $topicsRepository,
        ErrorsValidateEntityService $errorsValidateEntityService
    ) {
        $this->disciplineRepository = $disciplineRepository;
        $this->topicsRepository = $topicsRepository;
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    public function execute(array $jsonData, ?Topics $topics = null): void
    {
        if (!$topics) {
            $topics = FormFactory::create($jsonData, TopicsType::class, new Topics());
        } else {
            $topics = FormFactory::create($jsonData, TopicsType::class, $topics);
        }
        if ($errors = $this->errorsValidateEntityService->execute($topics)) {
            throw new TopicsException($errors, 400);
        }

        $topics->setStatus(true);
        if (!$topics->getCreatedAt()) {
            $topics->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
        }
        $this->topicsRepository->runSync($topics);
    }
}