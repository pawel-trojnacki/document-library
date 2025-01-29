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
     * } $data
     */
    public function transform(array $data): DocumentView
    {
        return new DocumentView(
            id: $data['id'],
            createdAt: $data['createdAt'],
            updatedAt: $data['updatedAt'],
            fileType: $data['fileType'],
            originalName: $data['originalName'],
            name: $data['name'],
            description: $data['description'],
            categoryName: $data['categoryName'],
            categoryId: $data['categoryId'],
        );
    }
}
