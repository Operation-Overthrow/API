<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordEncoder
    ) {
    }

    #[Route('/api/register', name: 'app_registration', methods: ['POST'])]
    #[OA\Tag(name: 'security')]
    #[OA\Response(
        response: 201,
        description: 'Returns the created game',
        content: new OA\JsonContent(
            ref: new Model(type: Game::class, groups: ['game:read', 'user:read:norelation'])
        )
    )]
    #[OA\RequestBody(
        description: 'The user to create',
        required: true,
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'user@operation-overthrow.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
            ]
        )
    )]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $errors = $this->validator->validate($data, new Collection([
            'email' => new Email,
            'password' => new PasswordStrength,
        ]));

        $errorsArray = [];
        foreach ($errors as $message) {
            $errorsArray[] = [
                'property' => $message->getPropertyPath(),
                'message' => $message->getMessage(),
            ];
        }

        if (count($errorsArray) > 0) {
            return $this->json($errorsArray, 400);
        }

        if ($this->entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']])) {
            return $this->json([['property' => '[email]', 'message' => 'Email already exists']], 400);
        }

        $user = new User;
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $data['password']));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json($user, 201, [], ['groups' => ['user:read']]);
    }
}
