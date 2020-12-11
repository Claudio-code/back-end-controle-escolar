<?php

namespace App\Controller;

use App\Entity\Matriculation;
use App\Exception\CourseException;
use App\Exception\MatriculationException;
use App\Exception\StudentException;
use App\Repository\MatriculationRepository;
use App\Service\MatriculationRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/matriculation", name="matriculation_")
 */
class MatriculationController extends AbstractController
{
    use TransformJson;
    
    private MatriculationRegisterService $matriculationRegisterService;
    
    public function __construct(MatriculationRegisterService $matriculationRegisterService)
    {
        $this->matriculationRegisterService = $matriculationRegisterService;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(MatriculationRepository $matriculationRepository): JsonResponse
    {
        return $this->json($matriculationRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Matriculation $matriculation): JsonResponse
    {
        return $this->json($matriculation);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Matriculation $matriculation, MatriculationRepository $matriculationRepository): JsonResponse
    {
        try {
            $matriculationRepository->runDelete($matriculation);
            
            return $this->json([
                'message' => 'Matricula removida com sucesso.',
            ], 200);
        } catch (MatriculationException $matriculationException) {
            return $this->json([
                'error' => $matriculationException->getMessage(),
            ], $matriculationException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico na hora de salvar os registros.',
            ], 500);
        }
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(Request $request, Matriculation $matriculation): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('ClasseId', $jsonData) || !array_key_exists('StudentId', $jsonData)) {
                throw new MatriculationException(
                    'Parametros não enviados',
                    401
                );
            }
            $this->matriculationRegisterService->execute($jsonData, $matriculation);

            return $this->json([
                'message' => 'Matricula atualizada com sucesso.',
            ], 200);
        } catch (MatriculationException $matriculationException) {
            return $this->json([
                'error' => $matriculationException->getMessage(),
            ], $matriculationException->getCode());
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (CourseException $courseException) {
            return $this->json([
                'error' => $courseException->getMessage(),
            ], $courseException->getCode());
        } catch (\Exception $exception) {
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
            if (!array_key_exists('ClasseId', $jsonData) || !array_key_exists('StudentId', $jsonData)) {
                throw new MatriculationException(
                    'Parametros não enviados',
                    401
                );
            }
            $this->matriculationRegisterService->execute($jsonData);

            return $this->json([
                'message' => 'Matricula criada com sucesso.',
            ], 200);
        } catch (MatriculationException $matriculationException) {
            return $this->json([
                'error' => $matriculationException->getMessage(),
            ], $matriculationException->getCode());
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (CourseException $courseException) {
            return $this->json([
                'error' => $courseException->getMessage(),
            ], $courseException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico na hora de salvar os registros.',
            ], 500);
        }
    }
}