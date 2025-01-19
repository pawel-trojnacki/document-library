<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Repository;

use App\Document\Domain\Entity\Document;
use App\Document\Domain\Repository\DocumentRepository as RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Document>
 */
final class DocumentRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function save(Document $document): void
    {
        $this->getEntityManager()->persist($document);
    }

    public function remove(Document $document): void
    {
        $this->getEntityManager()->remove($document);
    }

    public function findById(Uuid $id): ?Document
    {
        return $this->find($id);
    }
}
