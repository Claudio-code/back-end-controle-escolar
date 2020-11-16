<?php

namespace App\Controller;

use App\Entity\Student;
use App\Exception\AddressException;
use App\Exception\ResponsibleException;
use App\Exception\StudentException;
use App\Repository\StudentRepository;
use App\Service\StudentRegisterService;
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
     *
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
                'status' => 'Atualizado com sucesso.',
                'student' => $student,
            ], 201);
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com a atualização',
                $request->request->all(),
            ]);
        }
    }

    /**
     * @Route("/", name="create", methods={"POST"})
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
                'status' => 'Cadastrado com sucesso.',
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
     */
    public function index(StudentRepository $studentRepository): JsonResponse
    {
        return $this->json($studentRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Student $student): JsonResponse
    {
        return $this->json($student);
    }
}