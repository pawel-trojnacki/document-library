<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Service;

use App\Document\Application\Service\FileReader;
use App\Document\Domain\Enum\FileType;
use Smalot\PdfParser\Parser;

final class PdfReader implements FileReader
{
    public function __construct(private Parser $parser)
    {
    }

    public function getText(string $path): ?string
    {
        try {
            $file = $this->parser->parseFile($path);
            return $file->getText();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function getApplicableFileTypes(): array
    {
        return [FileType::PDF];
    }
}
