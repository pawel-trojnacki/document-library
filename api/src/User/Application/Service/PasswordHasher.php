<?php

declare(strict_types=1);

namespace App\User\Application\Service;

interface PasswordHasher
{
    public function hash(string $plainPassword): string;
}
