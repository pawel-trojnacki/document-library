<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Elasticsearch;

interface ElasticsearchClientInterface
{
    /*
     * @param mixed[] $body
     */
    public function createIndex(string $index, array $body): void;

    public function deleteIndex(string $index): void;

    public function indexExists(string $index): bool;

    public function refresh(string $index): void;

    /*
     * @param mixed[] $body
     */
    public function save(string $index, string $id, array $body): void;

    /*
     * @param mixed[] $body
     */
    public function update(string $index, string $id, array $body): void;

    /*
     * @param mixed[] $body
     */
    public function updateByQuery(string $index, array $body): void;

    public function delete(string $index, string $id): void;

    /**
     * @param mixed[] $body
     * @return mixed[]
     */
    public function search(string $index, array $body): array;
}
