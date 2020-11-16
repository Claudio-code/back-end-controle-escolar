<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Exception\TeacherException;
use App\Repository\TeacherRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher", name="theacher_")
 */
class TeacherController extends AbstractController
{
    use TransformJson;

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            return $this->json([
                'status' => 'Welcome to your new controller!',
                $jsonData,
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
     * @Route("/{id}", name="update", methods={"PUT"})
     */
    public function update(Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            return $this->json([
                'status' => 'Welcome to your new controller!',
                $jsonData,
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
    public function index(TeacherRepository $teacherRepository): JsonResponse
    {
        return $this->json($teacherRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Teacher $teacher): JsonResponse
    {
        return $this->json($teacher);
    }
}