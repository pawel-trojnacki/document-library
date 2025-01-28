<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\CategoryFactory;
use App\Document\Infrastructure\Projection\DocumentIndex;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DeleteCategoryActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    private DocumentIndex $documentIndex;

    protected function setUp(): void
    {
        parent::setUp();
        $this->documentIndex = self::getContainer()->get(DocumentIndex::class);
        $this->documentIndex->create();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->documentIndex->delete();
    }

    public function test_is_category_deleted(): void
    {
        $category = CategoryFactory::new()->create();

        $this->browser()
            ->delete('/categories/' . $category->getId())
            ->assertContentType('application/json')
            ->assertSuccessful();

        $this->assertNull(CategoryFactory::repository()->find($category->getId()));
    }

    public function test_is_error_when_category_is_not_found(): void
    {
        $this->browser()
            ->delete('/categories/' . Uuid::v7())
            ->assertContentType('application/json')
            ->assertStatus(404);
    }
}
