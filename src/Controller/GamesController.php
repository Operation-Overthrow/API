<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/games', name: 'app_game_')]
#[OA\Tag(name: 'games')]
#[Security(name: 'Bearer')]
class GamesController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private GameRepository $gameRepository)
    {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the list of games',
        content: new JsonContent(
            type: 'array',
            items: new Items(ref: new Model(type: Game::class, groups: ['game:read', 'user:read:norelation']))
        )
    )]
    public function index(): JsonResponse
    {
        $games = $this->gameRepository->findBy([
            'user' => $this->getUser(),
        ], [
            'score' => 'DESC',
        ]);

        return $this->json($games, 200, [], ['groups' => ['game:read', 'user:read:norelation']]);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    #[OA\Response(
        response: 201,
        description: 'Returns the created game',
        content: new JsonContent(
            ref: new Model(type: Game::class, groups: ['game:read', 'user:read:norelation'])
        )
    )]
    #[OA\RequestBody(
        description: 'The game to create',
        required: true,
        content: new JsonContent(
            type: 'object',
            properties: [
                new Property(property: 'score', type: 'integer', example: 100),
            ]
        )
    )]
    public function create(Request $request, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);
        $errors = $validator->validate($data, [
            'score' => new PositiveOrZero,
        ]);

        if (count($errors) > 0) {
            return $this->json([
                'errors' => $errors,
            ], 400);
        }

        $game = new Game;
        $game->setUser($this->getUser());
        $game->setScore($data['score']);

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $this->json($game, 201, [], ['groups' => ['game:read', 'user:read:norelation']]);
    }
}
