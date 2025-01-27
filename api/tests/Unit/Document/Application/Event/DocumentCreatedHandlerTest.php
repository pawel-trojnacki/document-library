<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document\Application\Event;

use App\Document\Application\Event\DocumentCreated;
use App\Document\Application\Event\DocumentCreatedHandler;
use App\Document\Application\Service\FileReader;
use App\Document\Application\Service\FileReaderProvider;
use App\Document\Application\Service\FileService;
use App\Document\Domain\Entity\Document;
use App\Document\Domain\Enum\FileType;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Event\Sync\EventBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DocumentCreatedHandlerTest extends TestCase
{
    public function test_is_event_handled(): void
    {
        $document = $this->createMock(Document::class);
        $document->method('getFileType')->willReturn(FileType::PDF);
        $documentRepository = $this->createMock(DocumentRepository::class);
        $documentRepository->method('findById')->willReturn($document);
        $fileReader = $this->createMock(FileReader::class);
        $fileReader->method('getApplicableFileTypes')->willReturn([FileType::PDF]);
        $fileReader->method('getText')->willReturn('content');
        $fileReaderProvider = new FileReaderProvider([$fileReader]);
        $fileService = $this->createMock(FileService::class);
        $eventBus = $this->createMock(EventBus::class);
        $handler = new DocumentCreatedHandler($documentRepository, $fileReaderProvider, $fileService, $eventBus);

        $fileReader
            ->expects($this->once())
            ->method('getText');
        $documentRepository
            ->expects($this->once())
            ->method('save')
            ->with($document);
        $eventBus
            ->expects($this->once())
            ->method('dispatch');

        $handler(new DocumentCreated(Uuid::v7()));
    }
}
