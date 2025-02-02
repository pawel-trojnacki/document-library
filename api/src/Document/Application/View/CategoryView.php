<?php

declare(strict_types=1);

namespace App\Document\Application\View;

readonly class CategoryView
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
