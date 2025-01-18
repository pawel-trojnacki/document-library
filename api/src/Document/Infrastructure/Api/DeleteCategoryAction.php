<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Api;

use App\Document\Application\Command\DeleteCategory;
use App\Document\Domain\Entity\Category;
use App\Shared\Application\Command\Sync\CommandBus;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories/{id}', name: 'category.delete', methods: ['DELETE'])]
final class DeleteCategoryAction extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(#[MapEntity] Category $category): Response
    {
        $command = new DeleteCategory($category);
        $this->commandBus->dispatch($command);

        return $this->json(null, Response::HTTP_OK);
    }
}
