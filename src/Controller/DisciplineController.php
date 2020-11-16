<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Exception\DisciplineException;
use App\Repository\DisciplineRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/discipline", name="discipline_")
 */
class DisciplineController extends AbstractController
{
    use TransformJson;

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        try {
            return $this->json([
                'status' => 'Disiplina criada com sucesso',
            ]);
        } catch (DisciplineException $disciplineException) {
            return $this->json([
                'error' => $disciplineException->getMessage(),
            ], $disciplineException->getCode());
        } catch (Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro ao tentar cadastrar a disiplina.',
            ], 500);
        }
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(DisciplineRepository $disciplineRepository): JsonResponse
    {
        return $this->json($disciplineRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Discipline $discipline): JsonResponse
    {
        return $this->json($discipline);
    }
}