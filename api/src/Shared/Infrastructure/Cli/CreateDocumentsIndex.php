<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Cli;

use App\Document\Infrastructure\Projection\DocumentIndex;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-documents-index',
    description: 'Create Elasticsearch documents index'
)]
final class CreateDocumentsIndex extends Command
{
    public function __construct(
        private DocumentIndex $documentIndex,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Creating documents index...');
        try {
            $this->documentIndex->create();
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Documents index created successfully');

        return Command::SUCCESS;
    }
}
