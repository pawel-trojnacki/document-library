<?php

declare(strict_types=1);

namespace App\Document\Application\Dto;

use App\Document\Domain\Enum\FileType;

readonly class StoredFileDto
{
    public function __construct(
        public FileType $fileType,
        public string $filePath,
        public string $originalName,
    ) {
    }
}
