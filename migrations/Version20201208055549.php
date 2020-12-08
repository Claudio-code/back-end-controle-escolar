<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208055549 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD coordinator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9E7877946 FOREIGN KEY (coordinator_id) REFERENCES teacher (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_169E6FB9E7877946 ON course (coordinator_id)');
        $this->addSql('ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3FE7877946');
        $this->addSql('DROP INDEX UNIQ_75BEEE3FE7877946 ON discipline');
        $this->addSql('ALTER TABLE discipline DROP coordinator_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9E7877946');
        $this->addSql('DROP INDEX UNIQ_169E6FB9E7877946 ON course');
        $this->addSql('ALTER TABLE course DROP coordinator_id');
        $this->addSql('ALTER TABLE discipline ADD coordinator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3FE7877946 FOREIGN KEY (coordinator_id) REFERENCES teacher (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75BEEE3FE7877946 ON discipline (coordinator_id)');
    }
}
