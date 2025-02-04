<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\Command;
use App\User\Application\Dto\ChangePasswordDto;
use App\User\Domain\Entity\User;

readonly class ChangePassword implements Command
{
    public function __construct(
        public User $user,
        public string $password,
    ) {
    }

    public static function create(User $user, ChangePasswordDto $dto): self
    {
        return new self(
            $user,
            $dto->password,
        );
    }
}
