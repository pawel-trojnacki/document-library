<?php

declare(strict_types=1);

namespace App\User\Application\Dto;

readonly class ChangePasswordDto
{
    public function __construct(
        public string $password,
    ) {
    }
}
