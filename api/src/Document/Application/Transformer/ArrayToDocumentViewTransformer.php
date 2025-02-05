<?php

declare(strict_types=1);

namespace App\Document\Application\Transformer;

use App\Document\Application\View\DocumentView;

final class ArrayToDocumentViewTransformer
{
    /**
     * @param array{
     *     id: string,
     *     createdAt: string,
     *     updatedAt: string,
     *     fileType: string,
     *     originalName: string,
     *     name: string,
     *     description: string|null,
     *     categoryName: string|null,
     *     categoryId: string|null,
     *     authorName: string|null,
     *     authorId: string|null,
     * } $data
     */
    public function transform(array $data): DocumentView
    {
        $categoryName = $data['categoryName'] ?? null;
        $categoryId = $data['categoryId'] ?? null;
        $authorName = $data['authorName'] ?? null;
        $authorId = $data['authorId'] ?? null;

        return new DocumentView(
            id: $data['id'],
            createdAt: (new \DateTimeImmutable($data['createdAt']))->format('Y-m-d H:i'),
            updatedAt: (new \DateTimeImmutable($data['updatedAt']))->format('Y-m-d H:i'),
            fileType: $data['fileType'],
            originalName: $data['originalName'],
            name: $data['name'],
            description: $data['description'],
            categoryName: $categoryName,
            categoryId: $categoryId,
            authorName: $authorName,
            authorId: $authorId,
        );
    }
}
