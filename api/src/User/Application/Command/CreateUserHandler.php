<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\CommandHandler;
use App\User\Application\Exception\UserAlreadyExists;
use App\User\Application\Service\PasswordHasher;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;

final class CreateUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher,
    ) {
    }

    public function __invoke(CreateUser $command): void
    {
        if ($this->userRepository->findOneByEmail($command->email) !== null) {
            throw new UserAlreadyExists($command->email);
        }

        $password = $this->passwordHasher->hash($command->password);

        $user = new User(
            $command->id,
            $command->role,
            $command->email,
            $command->firstName,
            $command->lastName,
            $password,
        );

        $this->userRepository->save($user);
    }
}
