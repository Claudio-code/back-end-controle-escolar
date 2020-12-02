<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Exception\TeacherException;
use App\Repository\TeacherRepository;
use App\Service\TeacherRegisterService;
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

    private TeacherRegisterService $teacherRegisterService;

    public function __construct(TeacherRegisterService $teacherRegisterService)
    {
        $this->teacherRegisterService = $teacherRegisterService;
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('Teacher', $jsonData)) {
                throw new TeacherException(
                    'Parametros não enviados para registrar o professor.',
                    401
                );
            }
            $this->teacherRegisterService->execute($jsonData['Teacher']);

            return $this->json([
                'status' => 'Criado um novo registro de professor.',
            ], 201);
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
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(Teacher $teacher, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('Teacher', $jsonData)) {
                throw new TeacherException(
                    'Parametros não enviados para registrar a displina.',
                    401
                );
            }
            $this->teacherRegisterService->execute($jsonData['Teacher'], $teacher);

            return $this->json([
                'status' => 'atualizada a disiplina com sucesso.',
            ], 201);
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

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     */
    public function remove(Teacher $teacher, TeacherRepository $teacherRepository): JsonResponse
    {
        try {
            $teacherRepository->runDelete($teacher);

            return $this->json([
                'message' => 'Professor removido',
            ], 201);
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
}