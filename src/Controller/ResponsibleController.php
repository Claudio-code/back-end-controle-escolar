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
     */
    public function update(Responsible $responsible, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            $this->responsibleRegisterService->execute($jsonData, $responsible);

            return $this->json([
                'status' => 'Atualizado com sucesso.',
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
     */
    public function create(Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            $this->responsibleRegisterService->execute($jsonData);

            return $this->json([
                'status' => 'Cadastrado com sucesso.',
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
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ResponsibleRepository $responsibleRepository): JsonResponse
    {
        return $this->json($responsibleRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Responsible $responsible): JsonResponse
    {
        return $this->json($responsible);
    }

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     */
    public function remove(Responsible $responsible, ResponsibleRepository $responsibleRepository): JsonResponse
    {
        try {
            $responsibleRepository->runDelete($responsible);

            return $this->json([
                'message' => 'Responsavel removido.',
            ], 201);
        } catch (ResponsibleException $responsibleException) {
            return $this->json([
                'error' => $responsibleException->getMessage(),
            ], $responsibleException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }
}