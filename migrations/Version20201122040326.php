<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201122040326 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, public_place VARCHAR(255) NOT NULL, number INT NOT NULL, status TINYINT(1) NOT NULL, cep VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6FCA7516CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, amount_hours INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_75BEEE3F41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_topics (discipline_id INT NOT NULL, topics_id INT NOT NULL, INDEX IDX_E9B6E828A5522701 (discipline_id), INDEX IDX_E9B6E828BF06A414 (topics_id), PRIMARY KEY(discipline_id, topics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsibles (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, parentesco VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, rg VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B5484364CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, rg VARCHAR(255) NOT NULL, cnh VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, ethnicity VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, coordinated_disipline_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, rg VARCHAR(255) NOT NULL, cnh VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, academic_title VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B0F6A6D58E6A0AA8 (coordinated_disipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, amount_hours INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, roles VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE discipline_topics ADD CONSTRAINT FK_E9B6E828A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_topics ADD CONSTRAINT FK_E9B6E828BF06A414 FOREIGN KEY (topics_id) REFERENCES topics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE responsibles ADD CONSTRAINT FK_B5484364CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D58E6A0AA8 FOREIGN KEY (coordinated_disipline_id) REFERENCES discipline (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discipline_topics DROP FOREIGN KEY FK_E9B6E828A5522701');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D58E6A0AA8');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516CB944F1A');
        $this->addSql('ALTER TABLE responsibles DROP FOREIGN KEY FK_B5484364CB944F1A');
        $this->addSql('ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3F41807E1D');
        $this->addSql('ALTER TABLE discipline_topics DROP FOREIGN KEY FK_E9B6E828BF06A414');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE discipline_topics');
        $this->addSql('DROP TABLE responsibles');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE topics');
        $this->addSql('DROP TABLE users');
    }
}
