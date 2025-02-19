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
     *     name: string,
     *     email: string,
     *     role: string,
     * } $data
     */
    public function transform(array $data): UserView
    {
        return new UserView(
            id: $data['id'],
            createdAt: $data['createdAt'],
            name: $data['name'],
            email: $data['email'],
            role: $data['role'],
        );
    }
}
