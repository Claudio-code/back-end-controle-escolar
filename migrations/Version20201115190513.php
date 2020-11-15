<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201115190513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, amount_hours INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_topics (discipline_id INT NOT NULL, topics_id INT NOT NULL, INDEX IDX_E9B6E828A5522701 (discipline_id), INDEX IDX_E9B6E828BF06A414 (topics_id), PRIMARY KEY(discipline_id, topics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, amount_hours INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discipline_topics ADD CONSTRAINT FK_E9B6E828A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_topics ADD CONSTRAINT FK_E9B6E828BF06A414 FOREIGN KEY (topics_id) REFERENCES topics (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discipline_topics DROP FOREIGN KEY FK_E9B6E828A5522701');
        $this->addSql('ALTER TABLE discipline_topics DROP FOREIGN KEY FK_E9B6E828BF06A414');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE discipline_topics');
        $this->addSql('DROP TABLE topics');
    }
}
