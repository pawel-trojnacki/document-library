<?php

declare(strict_types=1);

namespace App\Tests\Unit\User\Application\Event;

use App\Document\Application\Projection\DocumentProjection;
use App\User\Application\Event\UserEdited;
use App\User\Application\Event\UserEditedHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UserEditedHandlerTest extends TestCase
{
    public function test_is_event_handled(): void
    {
        $event = new UserEdited(Uuid::v7(), 'John Doe');
        $documentProjection = $this->createMock(DocumentProjection::class);
        $handler = new UserEditedHandler($documentProjection);

        $documentProjection->expects($this->once())
            ->method('bulkRefreshAuthor')
            ->with($event->id, $event->fullName);

        $handler($event);
    }
}
