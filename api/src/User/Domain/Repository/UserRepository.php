<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\Entity\User;
use Symfony\Component\Uid\Uuid;

interface UserRepository
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function findById(Uuid $id): ?User;

    public function findOneByEmail(string $email): ?User;
}
