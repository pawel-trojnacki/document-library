<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\CommandHandler;
use App\User\Domain\Repository\UserRepository;

final class EditUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(EditUser $command): void
    {
        $command->user->setRole($command->role);
        $command->user->setFirstName($command->firstName);
        $command->user->setLastName($command->lastName);

        $this->userRepository->save($command->user);
    }
}
