<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Fixtures;

use App\Document\Domain\Entity\Document;
use App\Document\Domain\Enum\FileType;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Document>
 */
final class DocumentFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Document::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'id' => Uuid::v7(),
            'category' => CategoryFactory::new(),
            'name' => self::faker()->word(),
            'fileType' => FileType::PDF,
            'filePath' => self::faker()->word() . '.pdf',
            'originalName' => self::faker()->word() . '.pdf',
            'description' => self::faker()->sentence(),
            'content' => self::faker()->text(),
        ];
    }
}
