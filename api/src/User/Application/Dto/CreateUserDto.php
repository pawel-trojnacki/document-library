<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

readonly class CreateUserDto
{
    public function __construct(
        public string $role = '',
        public string $email = '',
        public string $firstName = '',
        public string $lastName = '',
        public string $password = '',
    ) {
    }
}
