<?php

declare(strict_types=1);

namespace App\User\Domain\Enum;

enum UserRole: string
{
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';
}
