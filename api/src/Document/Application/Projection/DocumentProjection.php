<?php

declare(strict_types=1);

namespace App\Document\Application\Projection;

use App\Document\Domain\Entity\Document;

interface DocumentProjection
{
    public function save(Document $document): void;

    public function edit(Document $document): void;

    public function remove(Document $document): void;
}
