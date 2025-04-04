<?php

declare(strict_types=1);

namespace App\Document\Application\Service;

use App\Document\Application\Dto\StoredFileDto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileService
{
    public function upload(UploadedFile $file): StoredFileDto;

    public function delete(string $filePath): void;

    public function getUploadDir(): string;

    public function getStoredFilePath(string $path): ?string;
}
