<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Cli\ElasticSearch;

use App\Shared\Infrastructure\Factory\ElasticsearchClientFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:es-documents-create-index',
    description: 'Create Elasticsearch documents index'
)]
final class CreateDocumentsIndex extends Command
{
    public function __construct(
        private ElasticsearchClientFactory $clientFactory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Creating documents index...');

        $client = $this->clientFactory->create();

        $indexName = 'documents';
        $params = [
            'index' => $indexName,
            'body' => [
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
                        'category' => [
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
            ],
        ];

        try {
            $client->indices()->create($params);
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Documents index created successfully');

        return Command::SUCCESS;
    }
}
