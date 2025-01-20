<?php

declare(strict_types=1);

namespace App\Tests\Unit\Document\Infrastructure\Service;

use App\Document\Domain\Enum\FileType;
use App\Document\Infrastructure\Service\PdfReader;
use PHPUnit\Framework\TestCase;
use Smalot\PdfParser\Document as PdfDocument;
use Smalot\PdfParser\Parser;

class PdfReaderTest extends TestCase
{
    public function test_get_text(): void
    {
        $pdf = $this->createMock(PdfDocument::class);
        $pdf->method('getText')->willReturn('content');
        $parser = $this->createMock(Parser::class);
        $parser->method('parseFile')->willReturn($pdf);

        $pdfReader = new PdfReader($parser);

        $this->assertEquals('content', $pdfReader->getText('path', FileType::PDF));
    }

    public function test_is_null_returned_when_exception_is_thrown(): void
    {
        $parser = $this->createMock(Parser::class);
        $parser->method('parseFile')->willThrowException(new \Exception());

        $pdfReader = new PdfReader($parser);

        $this->assertNull($pdfReader->getText('path', FileType::PDF));
    }
}
