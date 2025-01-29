<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Projection;

use App\Shared\Infrastructure\Elasticsearch\ElasticsearchClientInterface;

final class DocumentIndex
{
    public const INDEX = 'documents';

    public function __construct(
        private ElasticsearchClientInterface $client,
    ) {
    }

    public function create(): void
    {
        if (!$this->client->indexExists(self::INDEX)) {
            $this->client->createIndex(self::INDEX, [
                'mappings' => [
                    'dynamic' => 'strict',
                    'properties' => [
                        'id' => [
                            'type' => 'keyword',
                        ],
                        'createdAt' => [
                            'type' => 'date',
                            'format' => 'strict_date_time',
                        ],
                        'updatedAt' => [
                            'type' => 'date',
                            'format' => 'strict_date_time',
                        ],
                        'categoryId' => [
                            'type' => 'keyword',
                        ],
                        'categoryName' => [
                            'type' => 'keyword',
                        ],
                        'name' => [
                            'type' => 'text',
                            'analyzer' => 'english',
                        ],
                        'fileType' => [
                            'type' => 'keyword',
                        ],
                        'filePath' => [
                            'type' => 'keyword',
                        ],
                        'originalName' => [
                            'type' => 'keyword',
                        ],
                        'description' => [
                            'type' => 'text',
                            'analyzer' => 'english',
                        ],
                        'content' => [
                            'type' => 'text',
                            'analyzer' => 'english',
                        ],
                    ],
                ],
            ]);
        }
    }

    public function delete(): void
    {
        $this->client->deleteIndex(self::INDEX);
    }

    public function refresh(): void
    {
        $this->client->refresh(self::INDEX);
    }
}
