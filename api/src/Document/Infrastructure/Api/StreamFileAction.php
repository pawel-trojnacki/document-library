<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Query\GetFile;
use App\Document\Application\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/documents/{id}/file', name: 'document.file', methods: ['GET'])]
final class StreamFileAction extends AbstractController
{
    public function __construct(
        private GetFile $query,
        private FileService $fileService,
    ) {
    }

    public function __invoke(string $id): Response
    {
        $file = $this->query->execute($id);
        if ($file === null) {
            return $this->json(null,Response::HTTP_NOT_FOUND);
        }

        $filePath = $this->fileService->getStoredFilePath($file->path);
        if ($filePath === null) {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }

        return $this->file($filePath, $file->name);
    }
}
