<?php

declare(strict_types=1);

namespace App\Document\Application\View;

readonly class DocumentView
{
    public function __construct(
        public string $id,
        public string $createdAt,
        public string $updatedAt,
        public string $fileType,
        public string $originalName,
        public string $name,
        public ?string $description,
        public ?string $categoryName,
        public ?string $categoryId,
    ) {
    }
}
