<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\Command;
use App\User\Application\Dto\CreateUserDto;
use App\User\Application\Dto\EditUserDto;
use App\User\Domain\Entity\User;
use App\User\Domain\Enum\UserRole;
use Symfony\Component\Uid\Uuid;

readonly class EditUser implements Command
{
    public function __construct(
        public User $user,
        public UserRole $role,
        public string $firstName,
        public string $lastName,
    ) {
    }

    public static function create(User $user, EditUserDto $dto): self
    {
        return new self(
            $user,
            UserRole::from($dto->role),
            $dto->firstName,
            $dto->lastName,
        );
    }
}
