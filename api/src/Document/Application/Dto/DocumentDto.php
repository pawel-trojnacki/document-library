<?php

declare(strict_types=1);

namespace App\Document\Application\Dto;

use Symfony\Component\Uid\Uuid;

readonly class DocumentDto
{
    public function __construct(
        public ?Uuid $categoryId = null,
        public string $name = '',
        public ?string $description = null,
    ) {
    }
}
