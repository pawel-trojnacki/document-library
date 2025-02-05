<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\CommandHandler;
use App\Shared\Application\Event\Sync\EventBus;
use App\User\Application\Event\UserDeleted;
use App\User\Domain\Repository\UserRepository;

final class DeleteUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private EventBus $eventBus,
    ) {
    }

    public function __invoke(DeleteUser $command): void
    {
        $this->userRepository->remove($command->user);
        $this->eventBus->dispatch(new UserDeleted($command->user->getId()));
    }
}
