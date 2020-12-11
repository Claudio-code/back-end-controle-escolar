<?php

namespace App\Controller;

use App\Entity\Course;
use App\Exception\CourseException;
use App\Repository\CourseRepository;
use App\Service\AddCoordinatorCourseService;
use App\Service\CourseRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course", name="course_")
 */
class CourseController extends AbstractController
{
    use TransformJson;

    private CourseRegisterService $courseRegisterService;

    private AddCoordinatorCourseService $addCoordinatorCourseService;

    public function __construct(
        CourseRegisterService $courseRegisterService,
        AddCoordinatorCourseService $addCoordinatorCourseService
    ) {
        $this->courseRegisterService = $courseRegisterService;
        $this->addCoordinatorCourseService = $addCoordinatorCourseService;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): JsonResponse
    {
        return $this->json($courseRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Course $course): JsonResponse
    {
        return $this->json($course);
    }

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     */
    public function remove(Course $course, CourseRepository $courseRepository): JsonResponse
    {
        try {
            $courseRepository->runDelete($course);

            return $this->json([
                'message' => 'Curso removido',
            ], 200);
        } catch (CourseException $courseException) {
            return $this->json([
                'error' => $courseException->getMessage(),
            ], $courseException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     */
    public function update(Course $course, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('Course', $jsonData)) {
                throw new CourseException(
                    'Course params not found.',
                    401
                );
            }
            $this->courseRegisterService->execute($jsonData['Course'], $course);

            return $this->json([
                'message' => 'Curso atualizado com sucesso.',
            ], 201);
        } catch (CourseException $courseException) {
            return $this->json([
                'error' => $courseException->getMessage(),
            ], $courseException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }

    /**
     * @Route("/addCoordinator/{id}", name="addCoordinator", methods={"PUT"})
     */
    public function addCoordinator(Request $request, Course $course): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('TeacherId', $jsonData)) {
                throw new CourseException(
                    'Parametros não enviados',
                    401
                );
            }
            $this->addCoordinatorCourseService->execute(intval($jsonData['TeacherId']), $course);

            return $this->json([
                'message' => 'Coordenador salvo com sucesso.',
            ], 201);
        } catch (CourseException $courseException) {
            return $this->json([
                'error' => $courseException->getMessage(),
            ], $courseException->getCode());
        } catch (\Exception $exception) {
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
            if (!array_key_exists('Course', $jsonData)) {
                throw new CourseException(
                    'Course params not found.',
                    401
                );
            }
            $this->courseRegisterService->execute($jsonData['Course']);

            return $this->json([
                'message' => 'Curso criado com sucesso.',
            ], 201);
        } catch (CourseException $courseException) {
            return $this->json([
                'error' => $courseException->getMessage(),
            ], $courseException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }
}