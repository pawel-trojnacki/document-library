<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Domain\Entity\Category;
use App\Shared\Application\Command\Sync\Command;

readonly class DeleteCategory implements Command
{
    public function __construct(
        public Category $category,
    ) {
    }
}
