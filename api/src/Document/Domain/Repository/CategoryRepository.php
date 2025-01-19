<?php

declare(strict_types=1);

namespace App\Document\Domain\Repository;

use App\Document\Domain\Entity\Category;
use Symfony\Component\Uid\Uuid;

interface CategoryRepository
{
    public function save(Category $category): void;

    public function remove(Category $category): void;

    public function findById(Uuid $id): ?Category;
}
