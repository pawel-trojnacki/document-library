<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Domain\Repository\CategoryRepository;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Command\Sync\CommandHandler;

final class EditDocumentHandler implements CommandHandler
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function __invoke(EditDocument $command): void
    {
        $document = $command->document;
        $category = null;
        if ($command->categoryId !== null) {
            $category = $this->categoryRepository->findById($command->categoryId);
        }

        $document->setCategory($category);
        $document->setName($command->name);
        $document->setDescription($command->description);

        $this->documentRepository->save($document);
    }
}
