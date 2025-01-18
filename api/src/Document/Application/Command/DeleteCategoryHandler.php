<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Domain\Repository\CategoryRepository;
use App\Shared\Application\Command\Sync\CommandHandler;

final class DeleteCategoryHandler implements CommandHandler
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function __invoke(DeleteCategory $command): void
    {
        $this->categoryRepository->remove($command->category);
    }
}
