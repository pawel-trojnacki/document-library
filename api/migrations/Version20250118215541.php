<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250118215541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create categories and documents tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE categories (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', category_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(120) NOT NULL, file_type VARCHAR(16) NOT NULL, file_path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_A2B0728812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B0728812469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B0728812469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE documents');
    }
}
