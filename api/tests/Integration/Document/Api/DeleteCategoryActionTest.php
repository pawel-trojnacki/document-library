<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\CategoryFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DeleteCategoryActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_category_deleted(): void
    {
        $category = CategoryFactory::new()->create();

        $this->browser()
            ->delete('/categories/' . $category->getId())
            ->assertSuccessful();

        $this->assertNull(CategoryFactory::repository()->find($category->getId()));
    }

    public function test_is_error_when_category_is_not_found(): void
    {
        $this->browser()
            ->delete('/categories/' . Uuid::v7())
            ->assertStatus(404);
    }
}
