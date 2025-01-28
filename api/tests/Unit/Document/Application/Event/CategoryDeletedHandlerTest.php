<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document\Application\Event;

use App\Document\Application\Event\CategoryDeleted;
use App\Document\Application\Event\CategoryDeletedHandler;
use App\Document\Application\Projection\DocumentProjection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CategoryDeletedHandlerTest extends TestCase
{
    public function test_is_event_handled(): void
    {
        $projection = $this->createMock(DocumentProjection::class);
        $handler = new CategoryDeletedHandler($projection);

        $projection->expects($this->once())
            ->method('bulkRemoveCategory');

        $handler(new CategoryDeleted(Uuid::v7()));
    }
}
