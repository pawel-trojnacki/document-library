<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Projection;

use App\Document\Application\Projection\DocumentProjection as ProjectionInterface;
use App\Document\Application\Transformer\DocumentToArrayTransformer;
use App\Document\Domain\Entity\Document;
use App\Shared\Infrastructure\Elasticsearch\ElasticsearchClientInterface;
use Symfony\Component\Uid\Uuid;

final class DocumentProjection implements ProjectionInterface
{
    public function __construct(
        private DocumentToArrayTransformer $transformer,
        private ElasticsearchClientInterface $client,
    ) {
    }

    public function save(Document $document): void
    {
        $this->client->save(
            DocumentIndex::INDEX,
            (string) $document->getId(),
            $this->transformer->transform($document)
        );
    }

    public function edit(Document $document): void
    {
        $this->client->update(
            DocumentIndex::INDEX,
            (string) $document->getId(),
            $this->transformer->transform($document)
        );
    }

    public function remove(Document $document): void
    {
        $this->client->delete(DocumentIndex::INDEX, (string) $document->getId());
    }

    public function bulkRemoveCategory(Uuid $categoryId): void
    {
        $this->client->updateByQuery(
            DocumentIndex::INDEX,
            [
                'script' => [
                    'source' => 'ctx._source.categoryId = null; ctx._source.categoryName = null;',
                ],
                'query' => [
                    'term' => [
                        'categoryId' => (string) $categoryId,
                    ],
                ],
            ],
        );
    }
}
