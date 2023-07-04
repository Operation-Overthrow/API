<?php

namespace App\Tests\Entity;

use App\Entity\Game;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use phpDocumentor\Reflection\DocBlock\Tags\Covers;

#[Covers(Game::class)]
class GameTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $game = new Game();
        $user = new User();
        $score = 42;

        $game->setUser($user);
        $game->setScore($score);

        $this->assertSame($user, $game->getUser());
        $this->assertSame($score, $game->getScore());
        $this->assertSame(null, $game->getId());
    }
}
