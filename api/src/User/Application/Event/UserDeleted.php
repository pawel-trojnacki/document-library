<?php

declare(strict_types=1);

namespace App\User\Application\Event;

use App\Shared\Application\Event\Sync\Event;
use Symfony\Component\Uid\Uuid;

readonly class UserDeleted implements Event
{
    public function __construct(
        public Uuid $id,
    ) {
    }
}
