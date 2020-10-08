<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\UserException;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    use TransformJson;
    use ErrorsValidateEntity;

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws Exception
     */
    public function create(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator
    ): JsonResponse {
        try {
            $jsonData = $this->transformStringToJson($request);
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->submit($jsonData);

            $user->setIsActive(true);
            $user->setCreatedAt(
                new DateTime("now", new DateTimeZone('America/Sao_Paulo'))
            );
            $user->setUpdatedAt(
                new DateTime("now", new DateTimeZone('America/Sao_Paulo'))
            );

            if ($errors = $this->validate($validator, $user)) {
                return $this->json(['errors' => $errors]);
            }

            $password = $passwordEncoder->encodePassword($user, $jsonData['password']);
            $user->setPassword($password);
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($user);
            $doctrine->flush();

            return $this->json([
                'message' => 'Cadastrado com sucesso.',
                'user' => $user
            ]);
        } catch (UserException $userException) {
            return $this->json([
                'error' => $userException
            ]);
        }
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     * @param UserRepository $userRepository
     */
    public function index(UserRepository $userRepository)
    {
        return $this->json($userRepository->findAll());
    }
}
