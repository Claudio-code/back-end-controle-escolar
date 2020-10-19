<?php

namespace App\Controller;

use App\Entity\Student;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/student", name="student_")
 */
class StudentController extends AbstractController
{
    use ErrorsValidateEntity;
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
    public function update(Student $student, Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            $jsonData = $this->transformStringToJson($request);
            $form = $this->createForm(StudentType::class, $student);
            $form->submit($jsonData);

            $student->setStatus(true);
            $student->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
            $student->setUpdatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );

            if ($errors = $this->validate($validator, $student)) {
                return $this->json(['errors' => $errors]);
            }

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->flush();

            return $this->json([
                'message' => 'Atualizado com sucesso.',
                'student' => $student,
            ]);
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     *
     * @throws \Exception
     */
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            $jsonData = $this->transformStringToJson($request);
            if (!array_key_exists('Student', $jsonData)) {
                return $this->json([
                    'error' => 'student params not found.',
                ], 400);
            }

            $this->studentRegisterService->execute($jsonData['Student']);

            return $this->json([
                'message' => 'Cadastrado com sucesso.',
                'student' => true,
            ], 201);
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/", name="index")
     */
    public function index(StudentRepository $studentRepository): JsonResponse
    {
        return $this->json($studentRepository->findAll());
    }
}
