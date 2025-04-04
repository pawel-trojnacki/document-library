<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

final class ElasticsearchClient implements ElasticsearchClientInterface
{
    private Client $client;

    public function __construct(private string $environment, string $host, string $port, string $user, string $password)
    {
        $this->client = ClientBuilder::create()
            ->setHosts([sprintf('%s:%s', $host, $port)])
            ->setBasicAuthentication($user, $password)
            ->setSSLVerification(false)
            ->build();
    }

    /*
     * @param mixed[] $body
     */
    public function createIndex(string $index, array $body): void
    {
        $this->client->indices()->create([
            'index' => $this->prepareIndexName($index),
            'body' => $body,
        ]);
    }

    public function deleteIndex(string $index): void
    {
        $this->client->indices()->delete([
            'index' => $this->prepareIndexName($index),
        ]);
    }

    public function indexExists(string $index): bool
    {
        return $this->client->indices()->exists([
            'index' => $this->prepareIndexName($index),
        ])->asBool();
    }

    public function mappingFieldExists(string $index, string $field): bool
    {
        $response = $this->client->indices()->getFieldMapping([
            'index' => $this->prepareIndexName($index),
            'fields' => [$field],
        ])->asObject();

        $mapping = $response->{$this->prepareIndexName($index)}?->mappings ?? [];

        return !empty((array) $mapping);
    }

    /**
     * @inheritDoc
     */
    public function updateMapping(string $index, array $body): void
    {
        $this->client->indices()->putMapping([
            'index' => $this->prepareIndexName($index),
            'body' => $body,
        ]);
    }

    public function refresh(string $index): void
    {
        $this->client->indices()->refresh([
            'index' => $this->prepareIndexName($index),
        ]);
    }

    /*
     * @param mixed[] $body
     */
    public function save(string $index, string $id, array $body): void
    {
        $this->client->index([
            'index' => $this->prepareIndexName($index),
            'id' => $id,
            'body' => $body,
        ]);
    }

    /*
     * @param mixed[] $body
     */
    public function update(string $index, string $id, array $body): void
    {
        $this->client->update([
            'index' => $this->prepareIndexName($index),
            'id' => $id,
            'body' => [
                'doc' => $body,
            ],
        ]);
    }

    /*
     * @param mixed[] $body
     */
    public function updateByQuery(string $index, array $body): void
    {
        $this->client->updateByQuery([
            'index' => $this->prepareIndexName($index),
            'body' => $body,
        ]);
    }

    public function delete(string $index, string $id): void
    {
        $this->client->delete([
            'index' => $this->prepareIndexName($index),
            'id' => $id,
        ]);
    }

    /**
     * @param mixed[] $body
     * @return mixed[]
     */
    public function search(string $index, array $body): array
    {
        return $this->client->search([
            'index' => $this->prepareIndexName($index),
            'body' => $body,
        ])->asArray();
    }

    private function prepareIndexName(string $index): string
    {
        if ($this->environment === 'test') {
            return 'test_' . $index;
        }

        return $index;
    }
}
