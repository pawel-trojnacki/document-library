<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\DocumentFactory;
use App\Document\Infrastructure\Projection\DocumentIndex;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateDocumentActionTest extends KernelTestCase
{
    use Factories, ResetDatabase, HasBrowser;

    private DocumentIndex $documentIndex;

    protected function setUp(): void
    {
        parent::setUp();

        $this->documentIndex = self::getContainer()->get(DocumentIndex::class);
        $this->documentIndex->create();

        $uploadDir = sys_get_temp_dir() . '/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->documentIndex->delete();
        $this->deleteDirectory(sys_get_temp_dir() . '/uploads');
    }

    public function test_is_document_created(): void
    {
        $pdfContent = '%PDF-1.4 Test PDF Content';
        $pdfPath = sys_get_temp_dir() . '/test-file.pdf';
        file_put_contents($pdfPath, $pdfContent);
        $file = new UploadedFile($pdfPath, 'test-file.pdf', 'application/pdf', null, true);

        $this->browser()
            ->post('/documents', [
                'json' => [
                    'name' => 'Sample Document',
                    'description' => 'Lorem ipsum dolor sit amet.',
                ],
                'files' => [
                    'file' => $file,
                ],
            ])
            ->assertSuccessful();

        $document = DocumentFactory::repository()->findOneBy(['name' => 'Sample Document']);
        $this->assertNotNull($document);
    }

    public function test_is_error_when_file_is_missing(): void
    {
        $this->browser()
            ->post('/documents', [
                'json' => [
                    'name' => 'Sample Document',
                    'description' => 'Lorem ipsum.',
                ],
            ])
            ->assertStatus(422);

        $this->assertNull(DocumentFactory::repository()->findOneBy(['name' => 'Sample Document']));
    }

    public function test_is_error_when_data_is_invalid(): void
    {
        $pdfContent = '%PDF-1.4 Test PDF Content';
        $pdfPath = sys_get_temp_dir() . '/test-file.pdf';
        file_put_contents($pdfPath, $pdfContent);
        $file = new UploadedFile($pdfPath, 'test-file.pdf', 'application/pdf', null, true);

        $this->browser()
            ->post('/documents', [
                'json' => [
                    'name' => '',
                    'description' => 'Lorem ipsum.',
                ],
                'files' => [
                    'file' => $file,
                ],
            ])
            ->assertStatus(422);

        $this->assertNull(DocumentFactory::repository()->findOneBy(['description' => 'Lorem ipsum.']));
    }

    private function deleteDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }

        $files = array_diff(scandir($directory), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $directory . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }

        rmdir($directory);
    }
}
