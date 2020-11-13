<?php

namespace App\Controller;

use App\Entity\Student;
use App\Exception\AddressException;
use App\Exception\ResponsibleException;
use App\Exception\StudentException;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use App\Service\StudentRegisterService;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student", name="student_")
 */
class StudentController extends AbstractController
{
    use TransformJson;

    private StudentRegisterService $studentRegisterService;

    public function __construct(StudentRegisterService $studentRegisterService)
    {
        $this->studentRegisterService = $studentRegisterService;
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     * @param Student $student
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(Student $student, Request $request): JsonResponse
    {
        try {
            $jsonData = $this->transformStringToJson($request);
            if (!array_key_exists('Student', $jsonData)) {
                return $this->json([
                    'error' => 'student params not found.',
                ], 401);
            }

            $this->studentRegisterService->execute($jsonData['Student']);

            return $this->json([
                'message' => 'Atualizado com sucesso.',
                'student' => $student,
            ], 201);
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com a atualização',
                $request->request->all()
            ]);
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
            if (!array_key_exists('Student', $jsonData)) {
                return $this->json([
                    'error' => 'student params not found.',
                ], 401);
            }

            $this->studentRegisterService->execute($jsonData['Student']);

            return $this->json([
                'message' => 'Cadastrado com sucesso.',
            ], 201);
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (AddressException $addressException) {
            return $this->json([
                'error' => $addressException->getMessage(),
            ], $addressException->getCode());
        } catch (ResponsibleException $responsibleException) {
            return $this->json([
                'error' => $responsibleException->getMessage(),
            ], $responsibleException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     * @param StudentRepository $studentRepository
     * @return JsonResponse
     */
    public function index(StudentRepository $studentRepository): JsonResponse
    {
        return $this->json($studentRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Student $student
     * @return JsonResponse
     */
    public function show(Student $student): JsonResponse
    {
        return $this->json($student);
    }
}