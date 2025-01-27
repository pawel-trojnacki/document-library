<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document\Application\Event;

use App\Document\Application\Event\DocumentDeleted;
use App\Document\Application\Event\DocumentDeletedHandler;
use App\Document\Application\Projection\DocumentProjection;
use App\Document\Domain\Entity\Document;
use App\Document\Domain\Repository\DocumentRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DocumentDeletedHandlerTest extends TestCase
{
    public function test_is_event_handled(): void
    {
        $document = $this->createMock(Document::class);
        $documentRepository = $this->createMock(DocumentRepository::class);
        $documentProjection = $this->createMock(DocumentProjection::class);
        $handler = new DocumentDeletedHandler($documentRepository, $documentProjection);

        $documentRepository->expects($this->once())
            ->method('findById')
            ->willReturn($document);

        $documentProjection->expects($this->once())
            ->method('remove')
            ->with($document);

        $handler(new DocumentDeleted(Uuid::v7()));
    }
}
