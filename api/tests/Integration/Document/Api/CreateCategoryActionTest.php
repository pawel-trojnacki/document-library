<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\CategoryFactory;
use App\User\Domain\Enum\UserRole;
use App\User\Infrastructure\Fixtures\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateCategoryActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_category_created(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->post('/categories', [
                'json' => [
                    'name' => 'My category'
                ],
            ])
            ->assertContentType('application/json')
            ->assertSuccessful();

        $this->assertNotNull(CategoryFactory::repository()->findOneBy(['name' => 'My category']));
    }

    public function is_error_when_data_is_invalid(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->post('/categories', [
                'json' => [
                    'name' => ''
                ],
            ])
            ->assertContentType('application/json')
            ->assertStatus(422);
    }
}
