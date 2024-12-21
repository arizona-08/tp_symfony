<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221021501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT fk_df7dfd0e3eb8070a');
        $this->addSql('DROP INDEX idx_df7dfd0e3eb8070a');
        $this->addSql('ALTER TABLE seance DROP program_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE seance ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT fk_df7dfd0e3eb8070a FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_df7dfd0e3eb8070a ON seance (program_id)');
    }
}
