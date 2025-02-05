<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250205213723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add author_id to documents table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE documents ADD author_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288F675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_A2B07288F675F31B ON documents (author_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288F675F31B');
        $this->addSql('DROP INDEX IDX_A2B07288F675F31B ON documents');
        $this->addSql('ALTER TABLE documents DROP author_id');
    }
}
