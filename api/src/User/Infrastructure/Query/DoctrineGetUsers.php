<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Query;

use App\User\Application\Query\GetUsers;
use App\User\Application\Transformer\ArrayToUserViewTransformer;
use Doctrine\DBAL\Connection;

final class DoctrineGetUsers implements GetUsers
{
    public function __construct(
        private Connection $connection,
        private ArrayToUserViewTransformer $transformer,
    ) {
    }

    public function execute(): array
    {
        $results = $this->connection
            ->createQueryBuilder()
                ->addSelect('BIN_TO_UUID(u.id) AS id')
                ->addSelect("DATE_FORMAT(u.created_at, '%Y-%m-%d %H:%i') AS createdAt")
                ->addSelect("CONCAT(u.first_name, ' ', u.last_name) AS name")
                ->addSelect('u.email')
                ->addSelect('u.role')
            ->from('users', 'u')
            ->orderBy('u.created_at', 'ASC')
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
