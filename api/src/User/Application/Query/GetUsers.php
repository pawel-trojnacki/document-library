<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\User\Application\View\UserView;

interface GetUsers
{
    /**
     * @return array{total: int, items: UserView[]}
     */
    public function execute(): array;
}
