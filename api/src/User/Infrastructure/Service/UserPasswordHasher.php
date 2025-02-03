<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Service;

use App\User\Application\Service\PasswordHasher;

final class UserPasswordHasher implements PasswordHasher
{
    public function __construct(
        private string $environment,
    ) {
    }

    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT, [
            'cost' => $this->environment === 'test' ? 4 : 12,
        ]);
    }
}
