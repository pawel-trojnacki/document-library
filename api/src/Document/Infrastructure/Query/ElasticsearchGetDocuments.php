<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Query;

use App\Document\Application\Query\GetDocuments;
use App\Document\Application\Transformer\ArrayToDocumentViewTransformer;
use App\Document\Infrastructure\Projection\DocumentIndex;
use App\Shared\Infrastructure\Elasticsearch\ElasticsearchClientInterface;

final class ElasticsearchGetDocuments implements GetDocuments
{
    public function __construct(
        private ElasticsearchClientInterface $client,
        private ArrayToDocumentViewTransformer $transformer,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(int $from, int $limit, ?string $search, ?string $categoryId): array
    {
        $filter = [];
        if ($categoryId) {
            $filter[] = ['term' => ['categoryId' => $categoryId]];
        }

        $body = [
            'from' => $from,
            'size' => $limit,
            'query' => [
                'bool' => [
                    'filter' => $filter,
                ],
            ],
        ];

        if ($search !== null) {
            $body['query']['bool']['should'] = [
                [
                    'multi_match' => [
                        'query' => $search,
                        'fields' => [
                            'name^5',
                            'originalName^5',
                            'description^3',
                            'content^1',
                        ],
                        'type' => 'most_fields',
                        'operator' => 'or'
                    ]
                ]
            ];

            $body['query']['bool']['minimum_should_match'] = 1;
        }

        $result = $this->client->search(DocumentIndex::INDEX, $body);

        return [
            'total' => $result['hits']['total']['value'],
            'items' => array_map(
                fn(array $document) => $this->transformer->transform($document['_source']),
                $result['hits']['hits']
            ),
        ];
    }
}
