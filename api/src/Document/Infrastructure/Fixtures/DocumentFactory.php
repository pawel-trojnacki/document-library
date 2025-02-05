<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Fixtures;

use App\Document\Domain\Entity\Document;
use App\Document\Domain\Enum\FileType;
use App\Document\Infrastructure\Projection\DocumentProjection;
use App\User\Domain\Enum\UserRole;
use App\User\Infrastructure\Fixtures\UserFactory;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Document>
 */
final class DocumentFactory extends PersistentProxyObjectFactory
{
    public function __construct(
        private DocumentProjection $projection,
    ) {
        parent::__construct();
    }

    public static function class(): string
    {
        return Document::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'id' => Uuid::v7(),
            'author' => UserFactory::new(['role' => UserRole::ADMIN]),
            'category' => CategoryFactory::new(),
            'name' => self::faker()->word(),
            'fileType' => FileType::PDF,
            'filePath' => self::faker()->word() . '.pdf',
            'originalName' => self::faker()->word() . '.pdf',
            'description' => self::faker()->sentence(),
            'content' => self::faker()->text(),
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Document $document): void {
            $this->projection->save($document);
        });
    }
}
