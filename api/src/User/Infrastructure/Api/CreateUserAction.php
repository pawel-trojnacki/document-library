<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\Shared\Application\Command\Sync\CommandBus;
use App\User\Application\Command\CreateUser;
use App\User\Application\Dto\CreateUserDto;
use App\User\Domain\Enum\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/users', name: 'users.create', methods: ['POST'])]
#[IsGranted(UserRole::ADMIN->value)]
final class CreateUserAction extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(#[MapRequestPayload] CreateUserDto $dto): Response
    {
        $this->commandBus->dispatch(CreateUser::fromDto($dto));

        return $this->json(null, Response::HTTP_CREATED);
    }
}
