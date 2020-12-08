<?php

namespace App\Controller;

use App\Entity\Address;
use App\Exception\AddressException;
use App\Exception\StudentException;
use App\Repository\AddressRepository;
use App\Service\AddressRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/address", name="address_")
 */
class AddressController extends AbstractController
{
    use TransformJson;

    private AddressRegisterService $addressRegisterService;

    public function __construct(AddressRegisterService $addressRegisterService)
    {
        $this->addressRegisterService = $addressRegisterService;
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(Address $address, Request $request): JsonResponse
    {
        $jsonData = $this->transformStringToJson($request);

        try {
            $this->addressRegisterService->execute($jsonData, $address);

            return $this->json([
                'status' => 'Atualizado com sucesso.',
            ], 201);
        } catch (AddressException $addressException) {
            return $this->json([
                'error' => $addressException->getMessage(),
            ], $addressException->getCode());
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
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
            $this->addressRegisterService->execute($jsonData);

            return $this->json([
                'status' => 'Cadastrado com sucesso',
            ], 201);
        } catch (AddressException $addressException) {
            return $this->json([
                'error' => $addressException->getMessage(),
            ], $addressException->getCode());
        } catch (StudentException $studentException) {
            return $this->json([
                'error' => $studentException->getMessage(),
            ], $studentException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(AddressRepository $addressRepository): JsonResponse
    {
        return $this->json($addressRepository->findAll());
    }

    /**
     * @Route("/{id}", name="index", methods={"GET"})
     */
    public function show(Address $address): JsonResponse
    {
        return $this->json($address);
    }

    /**
     * @Route("/{id}", name="remove", methods={"DELETE"})
     */
    public function remove(Address $address, AddressRepository $addressRepository): JsonResponse
    {
        try {
            $addressRepository->runDelete($address);

            return $this->json([
                'message' => 'Endereço removido.',
            ], 201);
        } catch (AddressException $addressException) {
            return $this->json([
                'error' => $addressException->getMessage(),
            ], $addressException->getCode());
        } catch (\Exception $exception) {
            return $this->json([
                'error' => 'Ocorreu um erro generico com o cadastro',
            ], 500);
        }
    }
}