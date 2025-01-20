<?php

declare(strict_types=1);

namespace App\Document\Application\Event;

use App\Shared\Application\Event\Sync\EventHandler;

final class DocumentCreatedHandler implements EventHandler
{
    public function __invoke(DocumentCreated $event): void
    {
    }
}
