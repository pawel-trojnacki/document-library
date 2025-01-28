<?php

declare(strict_types=1);

namespace App\Document\Application\Event;

use App\Document\Application\Projection\DocumentProjection;
use App\Shared\Application\Event\Sync\EventHandler;

final class CategoryDeletedHandler implements EventHandler
{
    public function __construct(
        private DocumentProjection $documentProjection,
    ) {
    }

    public function __invoke(CategoryDeleted $event): void
    {
        $this->documentProjection->bulkRemoveCategory($event->id);
    }
}
