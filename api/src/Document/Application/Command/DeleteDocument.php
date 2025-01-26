<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Domain\Entity\Document;
use App\Shared\Application\Command\Sync\Command;

readonly class DeleteDocument implements Command
{
    public function __construct(
        public Document $document,
    ) {
    }
}
