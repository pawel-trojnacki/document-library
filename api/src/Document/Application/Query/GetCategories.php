<?php

declare(strict_types=1);

namespace App\Document\Application\Query;

use App\Document\Application\View\CategoryView;

interface GetCategories
{
    /**
     * @return array{total: int, items: CategoryView[]}
     */
    public function execute(): array;
}
