<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Query;

use App\Document\Application\Query\GetCategories;
use App\Document\Application\Transformer\ArrayToCategoryViewTransformer;
use Doctrine\DBAL\Connection;

final class DoctrineGetCategories implements GetCategories
{
    public function __construct(
        private Connection $connection,
        private ArrayToCategoryViewTransformer $transformer,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(): array
    {
        $results = $this->connection
            ->createQueryBuilder()
                ->addSelect('BIN_TO_UUID(c.id) AS id')
                ->addSelect('c.name')
            ->from('categories', 'c')
            ->orderBy('c.name', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        return [
            'total' => count($results),
            'items' => array_map(
                fn (array $result) => $this->transformer->transform($result),
                $results,
            ),
        ];
    }
}
