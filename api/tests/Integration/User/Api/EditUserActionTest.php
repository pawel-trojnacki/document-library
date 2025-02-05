<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Api;

use App\User\Domain\Enum\UserRole;
use App\User\Infrastructure\Fixtures\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class EditUserActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_user_edited(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);
        $user = UserFactory::createOne([
            'role' => UserRole::USER,
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->patch('users/' . $user->getId(), [
                'json' => [
                    'role' => 'ROLE_ADMIN',
                    'firstName' => 'Jane',
                    'lastName' => 'Smith',
                ]
            ])
            ->assertStatus(200);

        $editedUser = UserFactory::repository()->find($user->getId());
        $this->assertEquals(UserRole::ADMIN, $editedUser->getRole());
        $this->assertEquals('Jane', $editedUser->getFirstName());
        $this->assertEquals('Smith', $editedUser->getLastName());
    }

    public function test_is_error_when_user_does_not_exist(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->patch('users/' . Uuid::v7(), [
                'json' => [
                    'role' => 'ROLE_ADMIN',
                    'firstName' => 'Jane',
                    'lastName' => 'Smith',
                ]
            ])
            ->assertStatus(404);
    }

    public function test_is_error_when_data_is_not_valid(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);
        $user = UserFactory::createOne();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->patch('users/' . $user->getId(), [
                'json' => [
                    'role' => 'ROLE_ADMIN',
                    'firstName' => 'Jane',
                    'lastName' => '',
                ]
            ])
            ->assertStatus(422);
    }
}
