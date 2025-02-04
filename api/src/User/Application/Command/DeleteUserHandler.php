<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\CommandHandler;
use App\User\Domain\Repository\UserRepository;

final class DeleteUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(DeleteUser $command): void
    {
        $this->userRepository->remove($command->user);
    }
}
