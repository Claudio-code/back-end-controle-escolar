<?php

namespace App\Controller;

use App\Entity\Responsible;
use App\Exception\ResponsibleException;
use App\Exception\StudentException;
use App\Repository\ResponsibleRepository;
use App\Service\ResponsibleRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/responsible", name="responsible_")
 */
class ResponsibleController extends AbstractController
{
    use TransformJson;

    private ResponsibleRegisterService $responsibleRegisterService;

    public function __construct(ResponsibleRegisterService $responsibleRegisterService)
    {
        $this->responsibleRegisterService = $responsibleRegisterService;
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     * @param Responsible $responsible
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Responsible $responsible, Request $request): JsonResponse
    {
        try {
            $jsonData = $this->transformStringToJson($request);
            $this->responsibleRegisterService->execute($jsonData, $responsible);

            return $this->json([
                'status' => 'Atualizado com sucesso.'
            ], 201);
        } catch (ResponsibleException $responsibleException) {
            return $this->json([
                'error' => $responsibleException->getMessage(),
            ], $responsibleException->getCode());
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $jsonData = $this->transformStringToJson($request);
            $this->responsibleRegisterService->execute($jsonData);

            return $this->json([
                'status' => 'Cadastrado com sucesso.'
            ], 201);
        } catch (ResponsibleException $responsibleException) {
            return $this->json([
                'error' => $responsibleException->getMessage(),
            ], $responsibleException->getCode());
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @Route("/", name="findAll", methods={"GET"})
     * @param ResponsibleRepository $responsibleRepository
     * @return JsonResponse
     */
    public function index(ResponsibleRepository $responsibleRepository): JsonResponse
    {
        return $this->json($responsibleRepository->findAll());
    }
}