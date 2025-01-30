<?php

declare(strict_types=1);

namespace App\Document\Application\Transformer;

use App\Document\Application\View\FileView;

final class ArrayToFileViewTransformer
{
    /**
     * @param array{name: string, path: string} $data
     */
    public function transform(array $data): FileView
    {
        return new FileView(
            $data['name'],
            $data['path'],
        );
    }
}
