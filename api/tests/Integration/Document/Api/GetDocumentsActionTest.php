<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\CategoryFactory;
use App\Document\Infrastructure\Fixtures\DocumentFactory;
use App\Document\Infrastructure\Projection\DocumentIndex;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetDocumentsActionTest extends KernelTestCase
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

    public function test_are_documents_provided(): void
    {
        DocumentFactory::createMany(3);
        $this->documentIndex->refresh();

        $this->browser()
            ->get('/documents')
            ->assertSuccessful()
            ->assertJsonMatches('total', 3);

        $this->assertTrue(true);
    }

    public function test_are_documents_searched(): void
    {
        DocumentFactory::createOne(
            ['name' => 'First Document', 'description' => 'Irrelevant description.', 'content' => 'Content.']
        );
        DocumentFactory::createOne(
            ['name' => 'Second Document', 'description' => 'Document description.', 'content' => 'Content.']
        );
        DocumentFactory::createOne(
            ['name' => 'Irrelevant name', 'description' => 'Document description.', 'content' => 'Content.']
        );
        DocumentFactory::createOne(['name' => 'Another One', 'description' => null, 'content' => 'Content.']);

        $this->documentIndex->refresh();

        $this->browser()
            ->get('/documents?search=Document')
            ->assertSuccessful()
            ->assertJsonMatches('total', 3)
            ->assertJsonMatches('items[0].name', 'Second Document')
            ->assertJsonMatches('items[1].name', 'First Document')
            ->assertJsonMatches('items[2].name', 'Irrelevant name');
        ;
    }

    public function test_are_documents_filtered_by_category(): void
    {
        $category1 = CategoryFactory::createOne();
        $category2 = CategoryFactory::createOne();

        DocumentFactory::createOne(['category' => $category1]);
        DocumentFactory::createOne(['category' => $category1]);
        DocumentFactory::createOne(['category' => $category2]);

        $this->documentIndex->refresh();

        $this->browser()
            ->get('/documents?categoryId=' . (string) $category1->getId())
            ->assertSuccessful()
            ->assertJsonMatches('total', 2);
    }
}
