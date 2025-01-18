<?php

declare(strict_types=1);

namespace App\Document\Application\Command;

use App\Document\Domain\Entity\Category;
use App\Document\Domain\Repository\CategoryRepository;
use App\Shared\Application\Command\Sync\CommandHandler;

final class CreateCategoryHandler implements CommandHandler
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function __invoke(CreateCategory $command): void
    {
        $category = new Category($command->id, $command->name);
        $this->categoryRepository->save($category);
    }
}
