<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Command\DeleteDocument;
use App\Document\Domain\Entity\Document;
use App\Shared\Application\Command\Sync\CommandBus;
use App\User\Domain\Enum\UserRole;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/documents/{id}', name: 'document.delete', methods: ['DELETE'])]
#[IsGranted(UserRole::ADMIN->value)]
final class DeleteDocumentAction extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(#[MapEntity] Document $document): Response
    {
        $command = new DeleteDocument($document);
        $this->commandBus->dispatch($command);

        return $this->json(null, Response::HTTP_OK);
    }
}
