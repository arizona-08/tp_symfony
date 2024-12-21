<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220235016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE seance_exercice (seance_id INT NOT NULL, exercice_id INT NOT NULL, PRIMARY KEY(seance_id, exercice_id))');
        $this->addSql('CREATE INDEX IDX_8A34735E3797A94 ON seance_exercice (seance_id)');
        $this->addSql('CREATE INDEX IDX_8A3473589D40298 ON seance_exercice (exercice_id)');
        $this->addSql('ALTER TABLE seance_exercice ADD CONSTRAINT FK_8A34735E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance_exercice ADD CONSTRAINT FK_8A3473589D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD seance_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE seance_exercice DROP CONSTRAINT FK_8A34735E3797A94');
        $this->addSql('ALTER TABLE seance_exercice DROP CONSTRAINT FK_8A3473589D40298');
        $this->addSql('DROP TABLE seance_exercice');
        $this->addSql('ALTER TABLE seance DROP seance_date');
    }
}
