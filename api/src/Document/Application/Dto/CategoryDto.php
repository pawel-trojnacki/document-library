<?php

declare(strict_types=1);

namespace App\Document\Application\Dto;

readonly class CategoryDto
{
    public function __construct(
        public string $name = '',
    ) {
    }
}
