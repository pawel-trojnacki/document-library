<?php

declare(strict_types=1);

namespace App\User\Application\Transformer;

use App\User\Application\View\UserView;

final class ArrayToUserViewTransformer
{
    /**
     * @param array{
     *     id: string,
     *     createdAt: string,
     *     firstName: string,
     *     lastName: string,
     *     email: string,
     *     role: string,
     * } $data
     */
    public function transform(array $data): UserView
    {
        return new UserView(
            id: $data['id'],
            createdAt: $data['createdAt'],
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            email: $data['email'],
            role: $data['role'],
        );
    }
}
