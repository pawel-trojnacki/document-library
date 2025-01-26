<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Factory;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

final class ElasticsearchClientFactory
{
    public function __construct(
        private string $host,
        private string $port,
        private string $user,
        private string $password
    ) {
    }

    public function create(): Client
    {
        return ClientBuilder::create()
            ->setHosts([sprintf('%s:%s', $this->host, $this->port)])
            ->setBasicAuthentication($this->user, $this->password)
            ->setSSLVerification(false)
            ->build();
    }
}
