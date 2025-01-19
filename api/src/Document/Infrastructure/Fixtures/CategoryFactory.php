<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Fixtures;

use App\Document\Domain\Entity\Category;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Category>
 */
final class CategoryFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Category::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'id' => Uuid::v7(),
            'name' => self::faker()->word(),
        ];
    }
}
