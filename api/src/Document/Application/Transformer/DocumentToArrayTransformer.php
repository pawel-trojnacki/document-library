<?php

declare(strict_types=1);

namespace App\Document\Application\Transformer;

use App\Document\Domain\Entity\Document;

final class DocumentToArrayTransformer
{
    /**
     * @return array<string, string|null>
     */
    public function transform(Document $document): array
    {
        return [
            'id' => (string) $document->getId(),
            'createdAt' => $document->getCreatedAt()->format(\DateTimeImmutable::ATOM),
            'updatedAt' => $document->getUpdatedAt()->format(\DateTimeImmutable::ATOM),
            'categoryId' => $document->getCategory()?->getId() ?? null,
            'categoryName' => $document->getCategory()?->getName() ?? null,
            'name' => $document->getName(),
            'fileType' => $document->getFileType()->value,
            'filePath' => $document->getFilePath(),
            'originalName' => $document->getOriginalName(),
            'description' => $document->getDescription(),
            'content' => $document->getContent(),
        ];
    }
}
