<?php

declare(strict_types=1);

namespace App\Document\Application\Transformer;

use App\Document\Application\View\CategoryView;

final class ArrayToCategoryViewTransformer
{
    /**
     * @param array{id: string, name: string} $data
     */
    public function transform(array $data): CategoryView
    {
        return new CategoryView(
            $data['id'],
            $data['name'],
        );
    }
}
