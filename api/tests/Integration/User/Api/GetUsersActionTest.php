<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Api;

use App\User\Domain\Enum\UserRole;
use App\User\Infrastructure\Fixtures\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetUsersActionTest extends KernelTestCase
{
    use Factories, HasBrowser, ResetDatabase;

    public function test_are_users_provided(): void
    {
        $authenticatedUser = UserFactory::createOne([
            'role' => UserRole::ADMIN,
            'email' => 'johndoe@email.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);

        UserFactory::createMany(2);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->get('/users')
            ->assertSuccessful()
            ->assertJsonMatches('total', 3)
            ->assertJsonMatches('items[0].email', 'johndoe@email.com')
            ->assertJsonMatches('items[0].firstName', 'John')
            ->assertJsonMatches('items[0].lastName', 'Doe')
            ->assertJsonMatches('items[0].role', UserRole::ADMIN->value)
        ;
    }

    public function test_non_admin_user_cannot_access_endpoint(): void
    {
        $authenticatedUser = UserFactory::createOne([
            'role' => UserRole::USER,
        ]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->get('/users')
            ->assertStatus(403)
        ;
    }
}
