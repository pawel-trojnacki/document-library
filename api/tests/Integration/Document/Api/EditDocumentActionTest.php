<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\DocumentFactory;
use App\Document\Infrastructure\Projection\DocumentIndex;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class EditDocumentActionTest extends KernelTestCase
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

    public function test_is_document_updated(): void
    {
        $document = DocumentFactory::new()->create();

        $this->browser()
            ->patch('/documents/' . $document->getId(), [
                'json' => [
                    'name' => 'Updated Document',
                    'description' => 'Updated description.',
                ],
            ])
            ->assertSuccessful();

        $updatedDocument = DocumentFactory::repository()->findOneBy(['id' => $document->getId()]);
        $this->assertSame('Updated Document', $updatedDocument->getName());
        $this->assertSame('Updated description.', $updatedDocument->getDescription());
    }

    public function test_is_error_when_data_is_invalid(): void
    {
        $document = DocumentFactory::new()->create();

        $this->browser()
            ->patch('/documents/' . $document->getId(), [
                'json' => [
                    'name' => '',
                    'description' => 'Updated description.',
                ],
            ])
            ->assertStatus(422);
    }

    public function test_is_error_when_document_is_not_found(): void
    {
        $this->browser()
            ->patch('/documents/' . Uuid::v7())
            ->assertStatus(404);
    }
}
