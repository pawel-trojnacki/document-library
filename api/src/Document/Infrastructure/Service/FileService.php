<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Service;

use App\Document\Application\Dto\StoredFileDto;
use App\Document\Application\Service\FileService as FileServiceInterface;
use App\Document\Domain\Enum\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class FileService implements FileServiceInterface
{
    public function __construct(
        private string $uploadDir,
        private SluggerInterface $slugger,
    )  {
    }

    public function upload(UploadedFile $file): StoredFileDto
    {
        $fileType = FileType::fromMimeType($file->getMimeType());
        $extension = $file->guessExtension();
        $subDir = $this->getSubDir();

        $originalName = $file->getClientOriginalName();
        $originalName = pathinfo($originalName, PATHINFO_FILENAME);
        $originalName = $this->slugger->slug($originalName)->toString();

        $fileName = $originalName . '-' . uniqid() . '.' . $extension;
        $originalName = $originalName . '.' . $file->guessExtension();

        $file->move($this->uploadDir . '/' . $subDir, $fileName);

        return new StoredFileDto($fileType, $subDir . '/' . $fileName, $originalName);
    }

    public function delete(string $filePath): void
    {
        $filePath = $this->uploadDir . '/' . $filePath;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function getUploadDir(): string
    {
        return $this->uploadDir;
    }

    private function getSubDir(): string
    {
        return date('Y/m');
    }
}
