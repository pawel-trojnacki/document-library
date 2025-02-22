<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Security\Listener;

use App\User\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;

final class JwtAuthenticatedListener
{
    public function __invoke(JWTAuthenticatedEvent $event): void
    {
        $user = $event->getToken()->getUser();
        if (!$user instanceof User) {
            return;
        }

        $payload = $event->getPayload();
        $iat = (int) $payload['iat'];
        if ($user->getLastPasswordUpdate() > $iat) {
            throw new InvalidTokenException('Token has expired');
        }
    }
}
