<?php

namespace App\Controller;

use App\Entity\Topics;
use App\Exception\TopicsException;
use App\Repository\TopicsRepository;
use App\Service\TopicsRegisterService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topics", name="topics_")
 */
class TopicsController extends AbstractController
{
    use TransformJson;

    private TopicsRegisterService $topicsRegisterService;

    public function __construct(TopicsRegisterService $topicsRegisterService)
    {
        $this->topicsRegisterService = $topicsRegisterService;
    }

    /**
     * @Route("/{id}", name="update", methods={"PATCH", "PUT"})
     */
    public function update(Topics $topics, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('Topic', $jsonData)) {
                throw new TopicsException(
                    'Topic params not found.',
                    401
                );
            }
            $this->topicsRegisterService->execute($jsonData['Topic'], $topics);

            return $this->json([
                'status' => 'Topico atualizado com sucesso.',
            ], 201);
        } catch (TopicsException $topicsException) {
            return $this->json([
                'error' => $topicsException->getMessage(),
            ], $topicsException->getCode());
        } catch (Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico na hora de salvar os registros.',
            ], 500);
        }
    }

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     */
    public function remove(Topics $topics, TopicsRepository $topicsRepository): JsonResponse
    {
        try {
            $topicsRepository->runDelete($topics);

            return $this->json([
                'message' => 'Produto removido',
            ], 201);
        } catch (TopicsException $topicsException) {
            return $this->json([
                'error' => $topicsException->getMessage(),
            ], $topicsException->getCode());
        } catch (Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
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
            if (!array_key_exists('Topics', $jsonData)) {
                throw new TopicsException(
                    'Topic params not found.',
                    401
                );
            }
            $this->topicsRegisterService->execute($jsonData['Topics']);

            return $this->json([
                'status' => 'Topico criado com sucesso.',
            ], 201);
        } catch (TopicsException $topicsException) {
            return $this->json([
                'error' => $topicsException->getMessage(),
            ], $topicsException->getCode());
        } catch (Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico na hora de salvar os registros.',
            ], 500);
        }
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(TopicsRepository $topicsRepository): JsonResponse
    {
        return $this->json($topicsRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Topics $topics): JsonResponse
    {
        return $this->json($topics);
    }
}