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

class ChangePasswordActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_password_changed(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);
        $user = UserFactory::createOne();
        $oldPassword = $user->getPassword();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->patch('/users/' . $user->getId() . '/change-password', [
                'json' => [
                    'password' => 'newpassword',
                ]
            ])
            ->assertSuccessful();

        $this->assertNotEquals($oldPassword, UserFactory::repository()->find($user->getId())->getPassword());
    }

    public function test_is_error_when_user_does_not_exist(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->patch('/users/' . Uuid::v7() . '/change-password', [
                'json' => [
                    'password' => 'newpassword',
                ]
            ])
            ->assertStatus(404);
    }

    public function test_is_error_when_password_is_too_short(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);
        $user = UserFactory::createOne();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->patch('/users/' . $user->getId() . '/change-password', [
                'json' => [
                    'password' => 'short',
                ]
            ])
            ->assertStatus(422);
    }

    public function test_is_error_when_no_admin_changes_other_user_password(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::USER]);
        $user = UserFactory::createOne();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->patch('/users/' . $user->getId() . '/change-password', [
                'json' => [
                    'password' => 'newpassword',
                ]
            ])
            ->assertStatus(403);
    }
}
