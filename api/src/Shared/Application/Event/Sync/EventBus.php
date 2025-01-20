<?php

declare(strict_types=1);

namespace App\Shared\Application\Event\Sync;

interface EventBus
{
    public function dispatch(Event $event): void;
}
