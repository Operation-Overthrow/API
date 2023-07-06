<?php

namespace App\Tests\Entity;

use App\Entity\Game;
use App\Entity\User;
use phpDocumentor\Reflection\DocBlock\Tags\Covers;
use PHPUnit\Framework\TestCase;

#[Covers(User::class)]
class UserTest extends TestCase
{
    /**
     * @test
     */
    public function gettersAndSetters(): void
    {
        $user = new User;
        $email = 'test@example.com';
        $password = 'password';
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];

        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($roles);

        $this->assertSame($email, $user->getUserIdentifier());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($password, $user->getPassword());
        $this->assertSame($roles, $user->getRoles());
        $this->assertSame(null, $user->getId());
    }

    /**
     * @test
     */
    public function addAndRemoveGame(): void
    {
        $user = new User;
        $game = new Game;

        $user->addGame($game);

        $this->assertTrue($user->getGames()->contains($game));
        $this->assertSame($user, $game->getUser());

        $user->removeGame($game);

        $this->assertFalse($user->getGames()->contains($game));
        $this->assertNull($game->getUser());
    }

    /**
     * @test
     */
    public function eraseCredentials(): void
    {
        $user = new User;
        $user->setPassword('password');

        $user->eraseCredentials();

        $this->assertSame('', $user->getPassword());
    }
}
