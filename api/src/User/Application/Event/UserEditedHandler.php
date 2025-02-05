<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use App\Document\Application\Projection\DocumentProjection;
use App\Shared\Application\Event\Sync\EventHandler;

final class UserEditedHandler implements EventHandler
{
    public function __construct(
        private DocumentProjection $documentProjection,
    ) {
    }

    public function __invoke(UserEdited $event): void
    {
        $this->documentProjection->bulkRefreshAuthor($event->id, $event->fullName);
    }
}
