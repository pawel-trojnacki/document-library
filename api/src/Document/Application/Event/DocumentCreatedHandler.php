<?php

declare(strict_types=1);

namespace App\Document\Application\Event;

use App\Document\Application\Service\FileReaderProvider;
use App\Document\Application\Service\FileService;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Event\Sync\EventHandler;

final class DocumentCreatedHandler implements EventHandler
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private FileReaderProvider $fileReaderProvider,
        private FileService $fileService,
    ) {
    }

    public function __invoke(DocumentCreated $event): void
    {
        $document = $this->documentRepository->findById($event->id);
        if ($document === null) {
            return;
        }

        $fileReader = $this->fileReaderProvider->getReader($document->getFileType());
        if ($fileReader !== null) {
            $content = $fileReader->getText($this->fileService->getUploadDir() . '/' . $document->getFilePath());
            $document->setContent($content);
            $this->documentRepository->save($document);
        }
    }
}
