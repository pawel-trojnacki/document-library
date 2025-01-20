<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document\Application\Service;

use App\Document\Application\Service\FileReader;
use App\Document\Application\Service\FileReaderProvider;
use App\Document\Domain\Enum\FileType;
use PHPUnit\Framework\TestCase;

class FileReaderProviderTest extends TestCase
{
    public function test_is_reader_provided(): void
    {
        $docReader = $this->createMock(FileReader::class);
        $docReader->method('getApplicableFileTypes')->willReturn([FileType::DOC]);
        $pdfReader = $this->createMock(FileReader::class);
        $pdfReader->method('getApplicableFileTypes')->willReturn([FileType::PDF]);

        $provider = new FileReaderProvider([$docReader, $pdfReader]);

        $this->assertSame($docReader, $provider->getReader(FileType::DOC));
        $this->assertSame($pdfReader, $provider->getReader(FileType::PDF));
    }

    public function test_is_null_returned_when_no_reader_is_applicable(): void
    {
        $docReader = $this->createMock(FileReader::class);
        $docReader->method('getApplicableFileTypes')->willReturn([FileType::DOC]);
        $pdfReader = $this->createMock(FileReader::class);
        $pdfReader->method('getApplicableFileTypes')->willReturn([FileType::PDF]);

        $provider = new FileReaderProvider([$docReader, $pdfReader]);

        $this->assertNull($provider->getReader(FileType::XLS));
    }
}
