<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\UserException;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\ErrorsValidateEntityService;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    use TransformJson;

    private ErrorsValidateEntityService $errorsValidateEntityService;

    public function __construct(ErrorsValidateEntityService $errorsValidateEntityService)
    {
        $this->errorsValidateEntityService = $errorsValidateEntityService;
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     *
     * @throws Exception
     */
    public function create(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ): JsonResponse {
        $jsonData = $this->transformStringToJson($request);

        try {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->submit($jsonData);

            $user->setIsActive(true);
            $user->setCreatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );
            $user->setUpdatedAt(
                new DateTime('now', new DateTimeZone('America/Sao_Paulo'))
            );

            // if ($errors = $this->validate($validator, $user)) {
            //     return $this->json(['errors' => $errors]);
            // }

            $password = $passwordEncoder->encodePassword($user, $jsonData['password']);
            $user->setPassword($password);
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();

            return $this->json([
                'message' => 'Cadastrado com sucesso.',
                'user' => $user,
            ], 201);
        } catch (UserException $userException) {
            return $this->json([
                'error' => $userException->getMessage(),
            ], $userException->getCode());
        }
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function index(UserRepository $userRepository)
    {
        return $this->json($userRepository->findAll());
    }

    /**
     * @Route("/{id}", name="index", methods={"GET"})
     */
    public function show(User $user): JsonResponse
    {
        return $this->json($user);
    }
}