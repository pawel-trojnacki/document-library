<?php

declare(strict_types=1);

namespace App\User\Application\Service;

use App\User\Domain\Entity\User;

interface UserProvider
{
    public function getCurrentUser(): ?User;
}
