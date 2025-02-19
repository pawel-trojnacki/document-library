<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Api;

use App\User\Application\Query\GetUsers;
use App\User\Domain\Enum\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/users', name: 'users.index', methods: ['GET'])]
#[IsGranted(UserRole::ADMIN->value)]
final class GetUsersAction extends AbstractController
{
    public function __construct(
        private GetUsers $query,
    ) {
    }

    public function __invoke(): Response
    {
        $users = $this->query->execute();
        return $this->json($users);
    }
}