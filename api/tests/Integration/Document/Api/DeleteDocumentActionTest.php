<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\DocumentFactory;
use App\Document\Infrastructure\Projection\DocumentIndex;
use App\User\Domain\Enum\UserRole;
use App\User\Infrastructure\Fixtures\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DeleteDocumentActionTest extends KernelTestCase
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

    public function test_is_document_deleted(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);
        $document = DocumentFactory::createOne();

        $this->browser()
            ->actingAs($authenticatedUser)
            ->delete('/documents/' . $document->getId())
            ->assertSuccessful();

        $this->assertNull(DocumentFactory::repository()->findOneBy(['id' => $document->getId()]));
    }

    public function test_is_error_when_document_is_not_found(): void
    {
        $authenticatedUser = UserFactory::createOne(['role' => UserRole::ADMIN]);

        $this->browser()
            ->actingAs($authenticatedUser)
            ->delete('/documents/' . Uuid::v7())
            ->assertStatus(404);
    }
}
