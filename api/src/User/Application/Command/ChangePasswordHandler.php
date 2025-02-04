<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\CommandHandler;
use App\User\Application\Service\PasswordHasher;
use App\User\Domain\Repository\UserRepository;

final class ChangePasswordHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher,
    ) {
    }

    public function __invoke(ChangePassword $command): void
    {
        $user = $command->user;
        $user->setPassword($this->passwordHasher->hash($command->password));
        $this->userRepository->save($user);
    }
}
