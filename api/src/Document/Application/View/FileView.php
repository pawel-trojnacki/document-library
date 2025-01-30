<?php

declare(strict_types=1);

namespace App\Document\Application\View;

readonly class FileView
{
    public function __construct(
        public string $name,
        public string $path,
    ) {
    }
}
