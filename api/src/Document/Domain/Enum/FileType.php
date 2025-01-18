<?php

declare(strict_types=1);

namespace App\Document\Domain\Enum;

enum FileType: string
{
    case PDF = 'pdf';
    case DOC = 'doc';
    case SPREADSHEET = 'spreadsheet';
}
