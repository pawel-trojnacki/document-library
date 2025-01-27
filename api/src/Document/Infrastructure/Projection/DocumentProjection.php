<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Projection;

use App\Document\Application\Projection\DocumentProjection as ProjectionInterface;
use App\Document\Application\Transformer\DocumentToArrayTransformer;
use App\Document\Domain\Entity\Document;
use App\Shared\Infrastructure\Factory\ElasticsearchClientFactory;
use Elastic\Elasticsearch\Client;

final class DocumentProjection implements ProjectionInterface
{
    private const INDEX = 'documents';

    private Client $client;

    public function __construct(
        private DocumentToArrayTransformer $transformer,
        ElasticsearchClientFactory $clientFactory,
    ) {
        $this->client = $clientFactory->create();
    }

    public function save(Document $document): void
    {
        $this->client->index([
            'index' => self::INDEX,
            'id' => (string) $document->getId(),
            'body' => $this->transformer->transform($document),
        ]);
    }

    public function edit(Document $document): void
    {
        $this->client->update([
            'index' => self::INDEX,
            'id' => (string) $document->getId(),
            'body' => $this->transformer->transform($document),
        ]);
    }

    public function remove(Document $document): void
    {
        $this->client->delete([
            'index' => self::INDEX,
            'id' => (string) $document->getId(),
        ]);
    }
}
