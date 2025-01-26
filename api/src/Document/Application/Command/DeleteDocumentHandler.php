<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Application\Service\FileService;
use App\Document\Domain\Repository\DocumentRepository;
use App\Shared\Application\Command\Sync\CommandHandler;

final class DeleteDocumentHandler implements CommandHandler
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private FileService $fileService,
    ) {
    }

    public function __invoke(DeleteDocument $command): void
    {
        $this->fileService->delete($command->document->getFilePath());
        $this->documentRepository->remove($command->document);
    }
}
