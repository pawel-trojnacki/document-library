<?php

declare(strict_types=1);

namespace App\Document\Application\Service;

use App\Document\Domain\Enum\FileType;

final class FileReaderProvider
{
    /**
     * @param iterable<FileReader> $readers
     */
    public function __construct(private iterable $readers)
    {
    }

    public function getReader(FileType $type): ?FileReader
    {
        foreach ($this->readers as $reader) {
            if (in_array($type, $reader->getApplicableFileTypes(), true)) {
                return $reader;
            }
        }

        return null;
    }
}
