<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\CommandHandler;
use App\Shared\Application\Event\Sync\EventBus;
use App\User\Application\Event\UserEdited;
use App\User\Domain\Repository\UserRepository;

final class EditUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private EventBus $eventBus,
    ) {
    }

    public function __invoke(EditUser $command): void
    {
        $command->user->setRole($command->role);
        $command->user->setFirstName($command->firstName);
        $command->user->setLastName($command->lastName);

        $this->userRepository->save($command->user);

        $this->eventBus->dispatch(new UserEdited($command->user->getId(), $command->user->getFullName()));
    }
}
