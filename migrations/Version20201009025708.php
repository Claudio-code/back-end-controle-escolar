<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201009025708 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE andress DROP INDEX UNIQ_ACD54CE7CB944F1A, ADD INDEX IDX_ACD54CE7CB944F1A (student_id)');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2609925EB');
        $this->addSql('DROP INDEX UNIQ_A4698DB2609925EB ON students');
        $this->addSql('ALTER TABLE students DROP andress_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE andress DROP INDEX IDX_ACD54CE7CB944F1A, ADD UNIQUE INDEX UNIQ_ACD54CE7CB944F1A (student_id)');
        $this->addSql('ALTER TABLE students ADD andress_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2609925EB FOREIGN KEY (andress_id) REFERENCES andress (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A4698DB2609925EB ON students (andress_id)');
    }
}
