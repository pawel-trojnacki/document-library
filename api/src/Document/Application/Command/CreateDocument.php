<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Application\Dto\DocumentDto;
use App\Document\Application\Dto\StoredFileDto;
use App\Document\Domain\Enum\FileType;
use App\Shared\Application\Command\Sync\Command;
use App\User\Domain\Entity\User;
use Symfony\Component\Uid\Uuid;

readonly class CreateDocument implements Command
{
    public Uuid $id;

    public function __construct(
        public User $user,
        public ?Uuid $categoryId,
        public string $name,
        public ?string $description,
        public FileType $fileType,
        public string $filePath,
        public string $originalName,
    ) {
        $this->id = Uuid::v7();
    }

    public static function create(User $user, DocumentDto $documentDto, StoredFileDto $storedFileDto): self
    {
        return new self(
            user: $user,
            categoryId: $documentDto->categoryId,
            name: $documentDto->name,
            description: $documentDto->description,
            fileType: $storedFileDto->fileType,
            filePath: $storedFileDto->filePath,
            originalName: $storedFileDto->originalName,
        );
    }
}
