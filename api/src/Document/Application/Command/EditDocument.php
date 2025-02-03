<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Application\Dto\DocumentDto;
use App\Document\Application\Dto\StoredFileDto;
use App\Document\Domain\Entity\Document;
use App\Document\Domain\Enum\FileType;
use App\Shared\Application\Command\Sync\Command;
use Symfony\Component\Uid\Uuid;

readonly class EditDocument implements Command
{
    public function __construct(
        public Document $document,
        public ?Uuid $categoryId,
        public string $name,
        public ?string $description,
    ) {
    }

    public static function create(Document $document, DocumentDto $documentDto): self
    {
        return new self(
            document: $document,
            categoryId: $documentDto->categoryId,
            name: $documentDto->name,
            description: $documentDto->description,
        );
    }
}
