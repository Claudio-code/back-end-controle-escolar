<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008104316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE andress (id INT AUTO_INCREMENT NOT NULL, andress_id INT DEFAULT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, public_place VARCHAR(255) NOT NULL, number INT NOT NULL, status TINYINT(1) NOT NULL, cep VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_ACD54CE7609925EB (andress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE andress ADD CONSTRAINT FK_ACD54CE7609925EB FOREIGN KEY (andress_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE students ADD student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2CB944F1A FOREIGN KEY (student_id) REFERENCES andress (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A4698DB2CB944F1A ON students (student_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2CB944F1A');
        $this->addSql('DROP TABLE andress');
        $this->addSql('DROP INDEX UNIQ_A4698DB2CB944F1A ON students');
        $this->addSql('ALTER TABLE students DROP student_id');
    }
}
