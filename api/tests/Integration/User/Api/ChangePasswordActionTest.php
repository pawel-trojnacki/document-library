<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Api;

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
        $user = UserFactory::createOne();
        $oldPassword = $user->getPassword();

        $this->browser()
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
        $this->browser()
            ->patch('/users/' . Uuid::v7() . '/change-password', [
                'json' => [
                    'password' => 'newpassword',
                ]
            ])
            ->assertStatus(404);
    }

    public function test_is_error_when_password_is_too_short(): void
    {
        $user = UserFactory::createOne();

        $this->browser()
            ->patch('/users/' . $user->getId() . '/change-password', [
                'json' => [
                    'password' => 'short',
                ]
            ])
            ->assertStatus(422);
    }
}
