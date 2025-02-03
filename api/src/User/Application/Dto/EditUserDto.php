<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

readonly class EditUserDto
{
    public function __construct(
        public string $role = '',
        public string $firstName = '',
        public string $lastName = '',
    ) {
    }
}
