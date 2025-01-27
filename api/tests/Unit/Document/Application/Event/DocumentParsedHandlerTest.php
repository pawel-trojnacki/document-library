<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document\Application\Event;

use App\Document\Application\Event\DocumentParsed;
use App\Document\Application\Event\DocumentParsedHandler;
use App\Document\Application\Projection\DocumentProjection;
use App\Document\Domain\Entity\Document;
use App\Document\Domain\Repository\DocumentRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DocumentParsedHandlerTest extends TestCase
{
    public function test_is_event_handled(): void
    {
        $document = $this->createMock(Document::class);
        $documentRepository = $this->createMock(DocumentRepository::class);
        $documentProjection = $this->createMock(DocumentProjection::class);
        $handler = new DocumentParsedHandler($documentRepository, $documentProjection);

        $documentRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($document);

        $documentProjection
            ->expects($this->once())
            ->method('save')
            ->with($document);

        $handler(new DocumentParsed(Uuid::v7()));
    }
}
