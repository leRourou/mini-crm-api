<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250717054458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE note ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE task ALTER contact_id SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE note DROP name');
        $this->addSql('ALTER TABLE task ALTER contact_id DROP NOT NULL');
    }
}
