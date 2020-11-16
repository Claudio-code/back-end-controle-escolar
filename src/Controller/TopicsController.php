<?php

namespace App\Controller;

use App\Entity\Topics;
use App\Repository\TopicsRepository;
use App\Service\TopicsRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\TopicsException;
use Exception;

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
     * @param Topics $topics
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Topics $topics, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);
        try {
            if (!array_key_exists('Topic', $jsonData)) {
                return $this->json([
                    'error' => 'topic params not found.',
                ], 401);
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
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);
        try {
            if (!array_key_exists('Topic', $jsonData)) {
                return $this->json([
                    'error' => 'topic params not found.',
                ], 401);
            }
            $this->topicsRegisterService->execute($jsonData['Topic']);

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
     * @param TopicsRepository $topicsRepository
     * @return JsonResponse
     */
    public function index(TopicsRepository $topicsRepository): JsonResponse
    {
        return $this->json($topicsRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Topics $topics
     * @return JsonResponse
     */
    public function show(Topics $topics): JsonResponse
    {
        return $this->json($topics);
    }
}
