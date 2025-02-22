<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security\Listener;

use App\User\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

final class JwtCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();
        if ($user instanceof User) {
            $payload = $event->getData();
            $payload['id'] = $user->getId();
            $payload['email'] = $user->getEmail();
            $payload['name'] = $user->getFullName();
            $payload['role'] = $user->getRole();
            $payload['isAdmin'] = $user->isAdmin();
            $event->setData($payload);
        }
    }
}
