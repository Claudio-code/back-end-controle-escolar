<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008104701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE andress DROP FOREIGN KEY FK_ACD54CE7609925EB');
        $this->addSql('DROP INDEX UNIQ_ACD54CE7609925EB ON andress');
        $this->addSql('ALTER TABLE andress CHANGE andress_id student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE andress ADD CONSTRAINT FK_ACD54CE7CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACD54CE7CB944F1A ON andress (student_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE andress DROP FOREIGN KEY FK_ACD54CE7CB944F1A');
        $this->addSql('DROP INDEX UNIQ_ACD54CE7CB944F1A ON andress');
        $this->addSql('ALTER TABLE andress CHANGE student_id andress_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE andress ADD CONSTRAINT FK_ACD54CE7609925EB FOREIGN KEY (andress_id) REFERENCES students (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACD54CE7609925EB ON andress (andress_id)');
    }
}
