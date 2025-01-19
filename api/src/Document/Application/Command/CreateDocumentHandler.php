<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Domain\Entity\Document;
use App\Document\Domain\Repository\CategoryRepository;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Command\Sync\CommandHandler;

final class CreateDocumentHandler implements CommandHandler
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private DocumentRepository $documentRepository,
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
            $category,
            $command->name,
            $command->fileType,
            $command->filePath,
            $command->originalName,
            $command->description,
        );

        $this->documentRepository->save($document);
    }
}
