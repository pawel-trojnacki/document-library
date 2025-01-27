<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Application\Event\DocumentEdited;
use App\Document\Domain\Repository\CategoryRepository;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Command\Sync\CommandHandler;
use App\Shared\Application\Event\Sync\EventBus;

final class EditDocumentHandler implements CommandHandler
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private CategoryRepository $categoryRepository,
        private EventBus $eventBus,
    ) {
    }

    public function __invoke(EditDocument $command): void
    {
        $document = $command->document;
        $category = null;
        if ($command->categoryId !== null) {
            $category = $this->categoryRepository->findById($command->categoryId);
        }

        $document->setUpdatedAt(new \DateTimeImmutable());
        $document->setCategory($category);
        $document->setName($command->name);
        $document->setDescription($command->description);

        $this->documentRepository->save($document);

        $this->eventBus->dispatch(new DocumentEdited($document->getId()));
    }
}
