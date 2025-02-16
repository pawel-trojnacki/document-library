<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Command\CreateDocument;
use App\Document\Application\Dto\DocumentDto;
use App\Document\Application\Service\FileService;
use App\Shared\Application\Command\Sync\CommandBus;
use App\User\Application\Service\UserProvider;
use App\User\Domain\Entity\User;
use App\User\Domain\Enum\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints as Assert;

#[Route('/documents', name: 'document.create', methods: ['POST'])]
#[IsGranted(UserRole::ADMIN->value)]
final class CreateDocumentAction extends AbstractController
{
    public function __construct(
        private FileService $fileService,
        private CommandBus $commandBus,
        private UserProvider $userProvider,
    ) {
    }

    /**
     * @param UploadedFile|UploadedFile[] $file
     */
    public function __invoke(
        #[MapRequestPayload] DocumentDto $dto,
        #[MapUploadedFile(
            constraints: [
                new Assert\File(
                    maxSize: '10M',
                    mimeTypes: [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ],
                    filenameMaxLength: 120,
                ),
            ],
            name: 'file',
        )] UploadedFile|array $file,
    ): Response {
        if (is_array($file)) {
            return $this->json([
                'message' => empty($file) ? 'File is required' : 'Only one file is allowed',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var User $author */
        $author = $this->userProvider->getCurrentUser();
        $storedFileDto = $this->fileService->upload($file);
        $command = CreateDocument::create($author, $dto, $storedFileDto);
        $this->commandBus->dispatch($command);

        return $this->json(null, Response::HTTP_CREATED);
    }
}
