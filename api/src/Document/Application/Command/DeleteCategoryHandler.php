<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Application\Event\CategoryDeleted;
use App\Document\Domain\Repository\CategoryRepository;
use App\Shared\Application\Command\Sync\CommandHandler;
use App\Shared\Application\Event\Sync\EventBus;

final class DeleteCategoryHandler implements CommandHandler
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EventBus $eventBus,
    ) {
    }

    public function __invoke(DeleteCategory $command): void
    {
        $this->categoryRepository->remove($command->category);
        $this->eventBus->dispatch(new CategoryDeleted($command->category->getId()));
    }
}
