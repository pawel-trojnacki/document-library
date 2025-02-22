<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250222164441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add last_password_update column to users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD last_password_update INT DEFAULT NULL');
        $this->addSql('UPDATE users SET last_password_update = UNIX_TIMESTAMP(created_at)');
        $this->addSql('ALTER TABLE users MODIFY last_password_update INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP last_password_update');
    }
}
