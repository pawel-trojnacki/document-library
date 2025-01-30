<?php

declare(strict_types=1);

namespace App\Document\Application\Query;

use App\Document\Application\View\FileView;

interface GetFile
{
    public function execute(string $id): ?FileView;
}
