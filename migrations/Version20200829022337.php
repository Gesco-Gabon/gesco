<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200829022337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE operator (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', birth_date DATETIME NOT NULL, birth_place VARCHAR(180) NOT NULL, nationality VARCHAR(180) NOT NULL, phone_number VARCHAR(180) NOT NULL, activity VARCHAR(180) NOT NULL, identity_document VARCHAR(180) NOT NULL, identity_number VARCHAR(180) NOT NULL, firstname VARCHAR(180) NOT NULL, lastname VARCHAR(180) NOT NULL, email VARCHAR(180) DEFAULT NULL, sex VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD sex VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE operator');
        $this->addSql('ALTER TABLE `admin` DROP sex');
    }
}
