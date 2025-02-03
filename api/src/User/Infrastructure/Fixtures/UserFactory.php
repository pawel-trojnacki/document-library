<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Fixtures;

use App\User\Domain\Entity\User;
use App\User\Domain\Enum\UserRole;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
class UserFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return User::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'id' => Uuid::v7(),
            'role' => self::faker()->randomElement(UserRole::cases()),
            'email' => self::faker()->email(),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'password' => self::faker()->password(),
        ];
    }
}
