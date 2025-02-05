<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use App\Document\Application\Projection\DocumentProjection;
use App\Shared\Application\Event\Sync\EventHandler;

final class UserDeletedHandler implements EventHandler
{
    public function __construct(
        private DocumentProjection $documentProjection,
    ) {
    }

    public function __invoke(UserDeleted $event): void
    {
        $this->documentProjection->bulkRemoveAuthor($event->id);
    }
}
