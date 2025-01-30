<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Query;

use App\Document\Application\Query\GetDocument;
use App\Document\Application\Transformer\ArrayToDocumentViewTransformer;
use App\Document\Application\View\DocumentView;
use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Uuid;

final class DoctrineGetDocument implements GetDocument
{
    public function __construct(
        private Connection $connection,
        private ArrayToDocumentViewTransformer $transformer,
    ) {
    }

    public function execute(string $id): ?DocumentView
    {
        if (!Uuid::isValid($id)) {
            return null;
        }

        $result = $this->connection
            ->createQueryBuilder()
                ->addSelect('BIN_TO_UUID(d.id) AS id')
                ->addSelect('d.created_at AS createdAt')
                ->addSelect('d.updated_at AS updatedAt')
                ->addSelect('d.file_type AS fileType')
                ->addSelect('d.original_name AS originalName')
                ->addSelect('d.name')
                ->addSelect('d.description')
                ->addSelect('c.name AS categoryName')
                ->addSelect('BIN_TO_UUID(c.id) AS categoryId')
            ->from('documents', 'd')
            ->leftJoin('d', 'categories', 'c', 'd.category_id = c.id')
            ->where('d.id = UUID_TO_BIN(:id)')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAssociative();

        if ($result === false) {
            return null;
        }

        return $this->transformer->transform($result);
    }
}
