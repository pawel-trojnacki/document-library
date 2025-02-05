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

class DeleteUserActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_password_changed(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);
        $user = UserFactory::createOne();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->delete('/users/' . $user->getId())
            ->assertSuccessful();

        $this->assertNull(UserFactory::repository()->find($user->getId()));
    }

    public function test_is_error_when_user_does_not_exist(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->delete('/users/' . Uuid::v7())
            ->assertStatus(404);
    }
}
