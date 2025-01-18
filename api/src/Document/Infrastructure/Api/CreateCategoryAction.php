<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Command\CreateCategory;
use App\Document\Application\Dto\CategoryDto;
use App\Shared\Application\Command\Sync\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'category.create', methods: ['POST'])]
final class CreateCategoryAction extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(#[MapRequestPayload] CategoryDto $dto): Response
    {
        $command = CreateCategory::fromDto($dto);
        $this->commandBus->dispatch($command);

        return $this->json(null, Response::HTTP_CREATED);
    }
}
