<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger;

use App\Shared\Application\Command\Sync\Command;
use App\Shared\Application\Command\Sync\CommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class SyncCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandSyncBus)
    {
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->commandSyncBus->dispatch($command);
        } catch (HandlerFailedException $exception) {
            throw $exception->getPrevious() ?? $exception;
        }
    }
}
