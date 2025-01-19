<?php

declare(strict_types=1);

namespace App\Document\Domain\Repository;

use App\Document\Domain\Entity\Document;
use Symfony\Component\Uid\Uuid;

interface DocumentRepository
{
    public function save(Document $document): void;

    public function remove(Document $document): void;

    public function findById(Uuid $id): ?Document;
}