<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\Shared\Application\Command\Sync\CommandBus;
use App\User\Application\Command\ChangePassword;
use App\User\Application\Dto\ChangePasswordDto;
use App\User\Application\Service\UserProvider;
use App\User\Domain\Entity\User;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users/{id}/change-password', name: 'users.change_password', methods: ['PATCH'])]
final class ChangePasswordAction extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus,
        private UserProvider $userProvider,
    ) {
    }

    public function __invoke(
        #[MapEntity] User $user,
        #[MapRequestPayload] ChangePasswordDto $dto
    ): Response {
        /** @var User $loggedInUser */
        $loggedInUser = $this->userProvider->getCurrentUser();
        if ($loggedInUser->getId() !== $user->getId() && !$loggedInUser->isAdmin()) {
            throw $this->createAccessDeniedException();
        }

        $this->commandBus->dispatch(ChangePassword::create($user, $dto));

        return $this->json(null, Response::HTTP_OK);
    }
}
