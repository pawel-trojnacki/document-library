<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Api;

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
        $user = UserFactory::createOne();

        $this->browser()
            ->delete('/users/' . $user->getId())
            ->assertSuccessful();

        $this->assertNull(UserFactory::repository()->find($user->getId()));
    }

    public function test_is_error_when_user_does_not_exist(): void
    {
        $this->browser()
            ->delete('/users/' . Uuid::v7())
            ->assertStatus(404);
    }
}
