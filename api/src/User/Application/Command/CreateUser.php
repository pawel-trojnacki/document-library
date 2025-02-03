<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\Command;
use App\User\Application\Dto\CreateUserDto;
use App\User\Domain\Enum\UserRole;
use Symfony\Component\Uid\Uuid;

readonly class CreateUser implements Command
{
    public Uuid $id;

    public function __construct(
        public UserRole $role,
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $password,
    ) {
        $this->id = Uuid::v7();
    }

    public static function fromDto(CreateUserDto $dto): self
    {
        return new self(
            UserRole::from($dto->role),
            $dto->email,
            $dto->firstName,
            $dto->lastName,
            $dto->password,
        );
    }
}
