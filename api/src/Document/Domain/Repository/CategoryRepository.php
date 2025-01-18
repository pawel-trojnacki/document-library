<?php

declare(strict_types=1);

namespace App\Document\Domain\Repository;

use App\Document\Domain\Entity\Category;

interface CategoryRepository
{
    public function save(Category $category): void;

    public function remove(Category $category): void;
}
