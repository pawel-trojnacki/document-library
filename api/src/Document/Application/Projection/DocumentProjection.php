<?php

declare(strict_types=1);

namespace App\Document\Application\Projection;

use App\Document\Domain\Entity\Document;
use Symfony\Component\Uid\Uuid;

interface DocumentProjection
{
    public function save(Document $document): void;

    public function edit(Document $document): void;

    public function remove(Document $document): void;

    public function bulkRefreshAuthor(Uuid $authorId, string $authorName): void;

    public function bulkRemoveAuthor(Uuid $authorId): void;

    public function bulkRemoveCategory(Uuid $categoryId): void;
}
