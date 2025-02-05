<?php

declare(strict_types=1);

namespace App\Document\Application\Event;

use App\Document\Application\Projection\DocumentProjection;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Event\Sync\EventHandler;

final class DocumentEditedHandler implements EventHandler
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private DocumentProjection $documentProjection,
    ) {
    }

    public function __invoke(DocumentEdited $event): void
    {
        $document = $this->documentRepository->findById($event->id);
        if ($document === null) {
            return;
        }

        $this->documentProjection->edit($document);
    }
}
