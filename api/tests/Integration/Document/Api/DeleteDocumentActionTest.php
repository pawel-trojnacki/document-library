<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\DocumentFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DeleteDocumentActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_document_deleted(): void
    {
        $document = DocumentFactory::new()->create();

        $this->browser()
            ->delete('/documents/' . $document->getId())
            ->assertSuccessful();

        $this->assertNull(DocumentFactory::repository()->findOneBy(['id' => $document->getId()]));
    }

    public function test_is_error_when_document_is_not_found(): void
    {
        $this->browser()
            ->delete('/documents/' . Uuid::v7())
            ->assertStatus(404);
    }
}
