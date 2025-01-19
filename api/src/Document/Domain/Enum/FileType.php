<?php

declare(strict_types=1);

namespace App\Document\Domain\Enum;

enum FileType: string
{
    case PDF = 'pdf';
    case DOC = 'doc';
    case DOCX = 'docx';
    case XLS = 'xls';
    case XLSX = 'xlsx';
    case UNKNOWN = 'unknown';

    public const TYPES = [
        'application/pdf' => self::PDF,
        'application/msword' => self::DOC,
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => self::DOCX,
        'application/vnd.ms-excel' => self::XLS,
        'application/vnd.openxmlformats-officedocument.spreadsheet.sheet' => self::XLSX,
    ];

    public static function fromMimeType(string $mimeType): self
    {
        return self::TYPES[$mimeType] ?? self::UNKNOWN;
    }
}
