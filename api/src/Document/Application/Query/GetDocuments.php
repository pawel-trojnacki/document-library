<?php

declare(strict_types=1);

namespace App\Document\Application\Query;

use App\Document\Application\View\DocumentView;

interface GetDocuments
{
    /**
     * @return array{total: int, items: DocumentView[]}
     */
    public function execute(int $from, int $limit, ?string $search, ?string $categoryId): array;
}
