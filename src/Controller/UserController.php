<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @return JsonResponse
     */
    public function create(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        ValidatorInterface $validator
    ): JsonResponse {
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

        return $this->json(['data' => 'casa']);
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request)
    {
        $jsonData = $this->transformStringToJson($request);
        return $this->json([
            'message' => $jsonData,
            'path' => 'src/Controller/UserController.php',
        ]);
    }
}
