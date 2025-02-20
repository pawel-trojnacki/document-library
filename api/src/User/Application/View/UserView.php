<?php

declare(strict_types=1);

namespace App\User\Application\View;

final class UserView
{
    public function __construct(
        public string $id,
        public string $createdAt,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $role,
    ) {
    }
}