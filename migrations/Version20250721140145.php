<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250721140145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP CONSTRAINT FK_CFBDFA14E7A1254A');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT FK_8389C3D7E7A1254A');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25E7A1254A');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE opportunity DROP CONSTRAINT fk_8389c3d7e7a1254a');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT fk_8389c3d7e7a1254a FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT fk_cfbdfa14e7a1254a');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT fk_cfbdfa14e7a1254a FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT fk_527edb25e7a1254a');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT fk_527edb25e7a1254a FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
