<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241219125801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_exercice (program_id INT NOT NULL, exercice_id INT NOT NULL, PRIMARY KEY(program_id, exercice_id))');
        $this->addSql('CREATE INDEX IDX_652D3B783EB8070A ON program_exercice (program_id)');
        $this->addSql('CREATE INDEX IDX_652D3B7889D40298 ON program_exercice (exercice_id)');
        $this->addSql('CREATE TABLE seance (id SERIAL NOT NULL, adept_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EDA2C4275 ON seance (adept_id)');
        $this->addSql('ALTER TABLE program_exercice ADD CONSTRAINT FK_652D3B783EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE program_exercice ADD CONSTRAINT FK_652D3B7889D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EDA2C4275 FOREIGN KEY (adept_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6493EB8070A FOREIGN KEY (program_id) REFERENCES program (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D6493EB8070A ON "user" (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE program_exercice DROP CONSTRAINT FK_652D3B783EB8070A');
        $this->addSql('ALTER TABLE program_exercice DROP CONSTRAINT FK_652D3B7889D40298');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0EDA2C4275');
        $this->addSql('DROP TABLE program_exercice');
        $this->addSql('DROP TABLE seance');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6493EB8070A');
        $this->addSql('DROP INDEX IDX_8D93D6493EB8070A');
        $this->addSql('ALTER TABLE "user" DROP program_id');
    }
}
