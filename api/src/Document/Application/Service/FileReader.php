<?php

declare(strict_types=1);

namespace App\Document\Application\Service;

use App\Document\Domain\Enum\FileType;

interface FileReader
{
    public function getText(string $path, FileType $type): ?string;

    /**
     * @return FileType[]
     */
    public function getApplicableFileTypes(): array;
}
