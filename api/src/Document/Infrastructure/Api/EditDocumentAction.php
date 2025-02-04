<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Command\EditDocument;
use App\Document\Application\Dto\DocumentDto;
use App\Document\Domain\Entity\Document;
use App\Shared\Application\Command\Sync\CommandBus;
use App\User\Domain\Enum\UserRole;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/documents/{id}', name: 'document.edit', methods: ['PATCH'])]
#[IsGranted(UserRole::ADMIN->value)]
final class EditDocumentAction extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(
        #[MapEntity] Document $document,
        #[MapRequestPayload] DocumentDto $dto,
    ): Response {
        $command = EditDocument::create($document, $dto);
        $this->commandBus->dispatch($command);

        return $this->json(null, Response::HTTP_OK);
    }
}
