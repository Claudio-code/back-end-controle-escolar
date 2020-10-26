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
     * @param Address $address
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Address $address, Request $request): JsonResponse
    {
        try {
            $jsonData = $this->transformStringToJson($request);
            $this->addressRegisterService->execute($jsonData, $address);

            return $this->json([
                'status' => 'Atualizado com sucesso.'
            ]);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $jsonData = $this->transformStringToJson($request);
            $this->addressRegisterService->execute($jsonData);

            return $this->json([
                'status' => 'Cadastrado com sucesso'
            ]);
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
     * @param AddressRepository $addressRepository
     * @return JsonResponse
     */
    public function index(AddressRepository $addressRepository)
    {
        return $this->json($addressRepository->findAll());
    }
}