<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Exception\ClassesException;
use App\Repository\ClassesRepository;
use App\Service\ClasseRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/classes", name="classes_")
 */
class ClassesController extends AbstractController
{
    use TransformJson;

    private ClasseRegisterService $classeRegisterService;

    public function __construct(ClasseRegisterService $classeRegisterService)
    {
        $this->classeRegisterService = $classeRegisterService;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ClassesRepository $classesRepository): JsonResponse
    {
        return $this->json($classesRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Classes $classes): JsonResponse
    {
        return $this->json($classes);
    }

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     */
    public function remove(Classes $classes, ClassesRepository $classesRepository): JsonResponse
    {
        try {
            $classesRepository->runDelete($classes);

            return $this->json([
                'message' => 'Classe removida com sucesso.',
            ], 200);
        } catch (ClassesException $classesException) {
            return $this->json([
                'error' => $classesException->getMessage(),
            ], $classesException->getCode());
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
            if (!array_key_exists('Classe', $jsonData)) {
                throw new ClassesException(
                    'Classe params not found.',
                    401
                );
            }
            $this->classeRegisterService->execute($jsonData['Classe']);

            return $this->json([
                'message' => 'Classe criada com sucesso.',
            ], 201);
        } catch (ClassesException $classesException) {
            return $this->json([
                'error' => $classesException->getMessage(),
            ], $classesException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(Classes $classes, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            if (!array_key_exists('Classe', $jsonData)) {
                throw new ClassesException(
                    'Classe params not found.',
                    401
                );
            }
            $this->classeRegisterService->execute($jsonData['Classe'], $classes);

            return $this->json([
                'message' => 'Classe criada com sucesso.',
            ], 201);
        } catch (ClassesException $classesException) {
            return $this->json([
                'error' => $classesException->getMessage(),
            ], $classesException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }
}


