<?php

declare(strict_types=1);

namespace App\Document\Infrastructure\Service;

use App\Document\Application\Service\FileReader;
use App\Document\Domain\Enum\FileType;
use PhpOffice\PhpWord\Element\AbstractContainer;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\IOFactory;

class DocReader implements FileReader
{
    public function getText(string $path, FileType $type): ?string
    {
        $readerName = $this->getReaderNameByType($type);
        if ($readerName === null) {
            return null;
        }

        $phpWord = IOFactory::load($path, $readerName);
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $this->getWordText($element);
                }
            }
        }

        return $text;
    }

    /**
     * @inheritDoc
     */
    public function getApplicableFileTypes(): array
    {
        return [FileType::DOC, FileType::DOCX];
    }

    private function getReaderNameByType(FileType $type): ?string
    {
        return match ($type) {
            FileType::DOCX => 'Word2007',
            FileType::DOC => 'MsDoc',
            default => null,
        };
    }

    private function getWordText($element): string
    {
        $result = '';
        if ($element instanceof AbstractContainer) {
            foreach ($element->getElements() as $element) {
                $result .= $this->getWordText($element);
            }
        } elseif ($element instanceof Table) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    $result .= $this->getWordText($cell);
                }
            }
        }
        elseif (method_exists($element, 'getText')) {
            $result .= $element->getText();
        }

        return $result;
    }
}
