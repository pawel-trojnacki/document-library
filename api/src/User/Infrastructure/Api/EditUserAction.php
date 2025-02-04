<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\Shared\Application\Command\Sync\CommandBus;
use App\User\Application\Command\EditUser;
use App\User\Application\Dto\EditUserDto;
use App\User\Domain\Entity\User;
use App\User\Domain\Enum\UserRole;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/users/{id}', name: 'users.edit', methods: ['PATCH'])]
#[IsGranted(UserRole::ADMIN->value)]
final class EditUserAction extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(
        #[MapEntity] User $user,
        #[MapRequestPayload] EditUserDto $dto
    ): Response {
        $this->commandBus->dispatch(EditUser::create($user, $dto));

        return $this->json(null, Response::HTTP_OK);
    }
}
