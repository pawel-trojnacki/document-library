<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\Sync\Command;
use App\User\Domain\Entity\User;

readonly class DeleteUser implements Command
{
    public function __construct(
        public User $user,
    ) {
    }
}
