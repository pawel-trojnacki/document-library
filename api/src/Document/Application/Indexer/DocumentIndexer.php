<?php

declare(strict_types=1);

namespace App\Document\Application\Indexer;

use App\Document\Domain\Entity\Document;

interface DocumentIndexer
{
    public function save(Document $document): void;

    public function remove(Document $document): void;
}
