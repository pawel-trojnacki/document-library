<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger;

use App\Shared\Application\Event\Sync\Event;
use App\Shared\Application\Event\Sync\EventBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class SyncEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $eventSyncBus)
    {
    }

    public function dispatch(Event $event): void
    {
        try {
            $this->eventSyncBus->dispatch($event);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?? $exception;
        }
    }
}
