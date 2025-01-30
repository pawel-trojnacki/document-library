<?php

declare(strict_types=1);

namespace App\Document\Application\Query;

use App\Document\Application\View\DocumentView;

interface GetDocument
{
    public function execute(string $id): ?DocumentView;
}
