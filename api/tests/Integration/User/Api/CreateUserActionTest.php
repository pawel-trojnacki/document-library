<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Api;

use App\User\Domain\Enum\UserRole;
use App\User\Infrastructure\Fixtures\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateUserActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_user_created(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->post('/users', [
                'json' => [
                    'role' => 'ROLE_ADMIN',
                    'email' => 'test@test.com',
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'password' => 'password',
                ]
            ])
            ->assertStatus(201);
        ;

        $this->assertNotNull(UserFactory::repository()->findOneBy(['email' => 'test@test.com']));
    }

    public function test_is_error_when_data_is_invalid(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->post('/users', [
                'json' => [
                    'role' => 'ROLE_ADMIN',
                    'email' => 'test',
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'password' => 'short',
                ]
            ])
            ->assertStatus(422);
        ;

        $this->assertNull(UserFactory::repository()->findOneBy(['email' => 'test']));
    }

    public function test_is_error_when_user_already_exists(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);
        UserFactory::createOne(['email' => 'test@test.com']);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->post('/users', [
                'json' => [
                    'role' => 'ROLE_ADMIN',
                    'email' => 'test@test.com',
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                    'password' => 'password',
                ]
            ])
            ->assertStatus(409);
        ;
    }
}
