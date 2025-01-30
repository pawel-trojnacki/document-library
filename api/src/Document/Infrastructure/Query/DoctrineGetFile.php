<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Query;

use App\Document\Application\Query\GetFile;
use App\Document\Application\Transformer\ArrayToFileViewTransformer;
use App\Document\Application\View\FileView;
use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Uuid;

final class DoctrineGetFile implements GetFile
{
    public function __construct(
        private Connection $connection,
        private ArrayToFileViewTransformer $transformer,
    ) {
    }

    public function execute(string $id): ?FileView
    {
        if (!Uuid::isValid($id)) {
            return null;
        }

        $sql = <<<SQL
            SELECT
                original_name as name, file_path as path
            FROM documents
            WHERE id = UUID_TO_BIN(:id)
        SQL;

        $stmt = $this->connection->executeQuery($sql, ['id' => $id]);
        $result = $stmt->fetchAssociative();

        if ($result === false) {
            return null;
        }

        return $this->transformer->transform($result);
    }
}
