<?php

declare(strict_types=1);

namespace App\User\Application\Exception;

use App\Shared\Application\Exception\RuntimeException;

final class UserAlreadyExists extends RuntimeException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('User with email %s already exists', $email), 409);
    }
}
