<?php

namespace App\Controller;

use App\Exception\TeacherException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

/**
 * @Route("/teacher", name="theacher_")
 */
class TeacherController extends AbstractController
{
    use TransformJson;

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);
        try {

            return $this->json([
                'message' => 'Welcome to your new controller!',
                $jsonData
            ]);
        } catch (TeacherException $teacherException) {
            return $this->json([
                'error' => $teacherException->getMessage(),
            ], $teacherException->getCode());
        } catch (Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TheacherController.php',
        ]);
    }
}
