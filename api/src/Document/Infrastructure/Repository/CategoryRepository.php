<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Repository;

use App\Document\Domain\Entity\Category;
use App\Document\Domain\Repository\CategoryRepository as RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Category>
 */
final class CategoryRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $category): void
    {
        $this->getEntityManager()->persist($category);
    }

    public function remove(Category $category): void
    {
        $this->getEntityManager()->remove($category);
    }

    public function findById(Uuid $id): ?Category
    {
        return $this->find($id);
    }
}
