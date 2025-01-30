<?php

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Api\GetDocumentAction;
use App\Document\Infrastructure\Fixtures\DocumentFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetDocumentActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    public function test_is_document_provided(): void
    {
        $document = DocumentFactory::new()->create();

        $this->browser()
            ->get('/documents/' . $document->getId())
            ->assertSuccessful()
            ->assertJsonMatches('id', (string) $document->getId());
    }

    public function test_is_error_when_document_not_found(): void
    {
        $this->browser()
            ->get('/documents/' . (string) Uuid::v7())
            ->assertStatus(404);
    }
}
