<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130054453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE student_classes');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_classes (student_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_EFDBCB3D9E225B24 (classes_id), INDEX IDX_EFDBCB3DCB944F1A (student_id), PRIMARY KEY(student_id, classes_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE student_classes ADD CONSTRAINT FK_EFDBCB3D9E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_classes ADD CONSTRAINT FK_EFDBCB3DCB944F1A FOREIGN KEY (student_id) REFERENCES students (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
