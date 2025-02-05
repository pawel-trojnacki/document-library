<?php

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Api\GetDocumentAction;
use App\Document\Infrastructure\Fixtures\CategoryFactory;
use App\Document\Infrastructure\Fixtures\DocumentFactory;
use App\Document\Infrastructure\Projection\DocumentIndex;
use App\User\Infrastructure\Fixtures\UserFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetDocumentActionTest extends KernelTestCase
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

    public function test_is_document_provided(): void
    {
        $authenticatedUser = UserFactory::createOne();
        $document = DocumentFactory::createOne();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->get('/documents/' . $document->getId())
            ->assertSuccessful()
            ->assertJsonMatches('id', (string) $document->getId())
            ->assertJsonMatches('name', $document->getName())
            ->assertJsonMatches('description', $document->getDescription())
            ->assertJsonMatches('categoryId', (string) $document->getCategory()->getId())
            ->assertJsonMatches('categoryName', $document->getCategory()->getName())
            ->assertJsonMatches('authorId', (string) $document->getAuthor()->getId())
            ->assertJsonMatches('authorName', $document->getAuthor()->getFullName())
        ;
    }

    public function test_is_error_when_document_not_found(): void
    {
        $authenticatedUser = UserFactory::createOne();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->get('/documents/' . (string) Uuid::v7())
            ->assertStatus(404);
    }
}
