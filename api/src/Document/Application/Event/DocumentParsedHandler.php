<?php

declare(strict_types=1);

namespace App\Document\Application\Event;

use App\Document\Application\Indexer\DocumentIndexer;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Event\Sync\EventHandler;

final class DocumentParsedHandler implements EventHandler
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private DocumentIndexer $documentIndexer,
    ) {
    }

    public function __invoke(DocumentParsed $event): void
    {
        $document = $this->documentRepository->findById($event->id);
        if ($document === null) {
            return;
        }

        $this->documentIndexer->save($document);
    }
}
