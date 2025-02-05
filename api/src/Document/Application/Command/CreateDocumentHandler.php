<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Application\Event\DocumentCreated;
use App\Document\Domain\Entity\Document;
use App\Document\Domain\Repository\CategoryRepository;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Command\Sync\CommandHandler;
use App\Shared\Application\Event\Sync\EventBus;

final class CreateDocumentHandler implements CommandHandler
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private DocumentRepository $documentRepository,
        private EventBus $eventBus,
    ) {
    }

    public function __invoke(CreateDocument $command): void
    {
        $category = null;
        if ($command->categoryId !== null) {
            $category = $this->categoryRepository->findById($command->categoryId);
        }

        $document = new Document(
            $command->id,
            $command->user,
            $category,
            $command->name,
            $command->fileType,
            $command->filePath,
            $command->originalName,
            $command->description,
        );

        $this->documentRepository->save($document);

        $this->eventBus->dispatch(new DocumentCreated($document->getId()));
    }
}
