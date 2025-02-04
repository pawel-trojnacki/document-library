<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Service;

use App\User\Domain\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class UserProvider implements \App\User\Application\Service\UserProvider
{
    public function __construct(private TokenStorageInterface $tokenStorage) {
    }

    public function getCurrentUser(): ?User
    {
        $user = $this->tokenStorage->getToken()?->getUser();
        if ($user instanceof User) {
            return $user;
        }

        return null;
    }
}
