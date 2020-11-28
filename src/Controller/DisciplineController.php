<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Exception\DisciplineException;
use App\Repository\DisciplineRepository;
use App\Service\DisciplineRegisterService;
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

    private DisciplineRegisterService $disciplineRegisterService;

    public function __construct(DisciplineRegisterService $disciplineRegisterService)
    {
        $this->disciplineRegisterService = $disciplineRegisterService;
    }

    /**
     * @Route("/{id}", name="update", methods={"PATCH", "PUT"})
     */
    public function update(Discipline $discipline, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('Discipline', $jsonData)) {
                throw new DisciplineException(
                    'Discipline params not found.',
                    401
                );
            }
            $this->disciplineRegisterService->execute($jsonData['Discipline'], $discipline);

            return $this->json([
                'status' => 'Topico atualizado com sucesso.',
            ], 201);
        } catch (DisciplineException $disciplineException) {
            return $this->json([
                'error' => $disciplineException->getMessage(),
            ], $disciplineException->getCode());
        } catch (Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico na hora de salvar os registros.',
            ], 500);
        }
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('Discipline', $jsonData)) {
                throw new DisciplineException(
                    'Discipline params not found.',
                    401
                );
            }
            $this->disciplineRegisterService->execute($jsonData['Discipline']);

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

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     */
    public function remove(Discipline $discipline, DisciplineRepository $disciplineRepository): JsonResponse
    {
        try {
            $disciplineRepository->runDelete($discipline);

            return $this->json([
                'message' => 'Disiplina removida.',
            ], 201);
        } catch (DisciplineException $disciplineException) {
            return $this->json([
                'error' => $disciplineException->getMessage(),
            ], $disciplineException->getCode());
        } catch (Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }
}