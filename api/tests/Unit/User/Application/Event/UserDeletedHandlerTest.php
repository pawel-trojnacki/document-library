<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Application\Event;

use App\Document\Application\Projection\DocumentProjection;
use App\User\Application\Event\UserDeleted;
use App\User\Application\Event\UserDeletedHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UserDeletedHandlerTest extends TestCase
{
    public function test_is_event_handled(): void
    {
        $event = new UserDeleted(Uuid::v7());
        $documentProjection = $this->createMock(DocumentProjection::class);
        $handler = new UserDeletedHandler($documentProjection);

        $documentProjection->expects($this->once())
            ->method('bulkRemoveAuthor')
            ->with($event->id);

        $handler($event);
    }
}
