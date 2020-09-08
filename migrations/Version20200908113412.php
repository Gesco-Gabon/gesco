<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908113412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, place VARCHAR(64) NOT NULL, current BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE location_operator (location_id INT NOT NULL, operator_id UUID NOT NULL, PRIMARY KEY(location_id, operator_id))');
        $this->addSql('CREATE INDEX IDX_6F3856364D218E ON location_operator (location_id)');
        $this->addSql('CREATE INDEX IDX_6F38563584598A3 ON location_operator (operator_id)');
        $this->addSql('COMMENT ON COLUMN location_operator.operator_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE operator (id UUID NOT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, birth_place VARCHAR(180) NOT NULL, nationality VARCHAR(180) NOT NULL, phone_number VARCHAR(180) NOT NULL, activity VARCHAR(180) NOT NULL, identity_document VARCHAR(180) NOT NULL, identity_number VARCHAR(180) NOT NULL, firstname VARCHAR(180) NOT NULL, lastname VARCHAR(180) NOT NULL, sex VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN operator.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(180) NOT NULL, lastname VARCHAR(180) NOT NULL, sex VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE location_operator ADD CONSTRAINT FK_6F3856364D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE location_operator ADD CONSTRAINT FK_6F38563584598A3 FOREIGN KEY (operator_id) REFERENCES operator (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE location_operator DROP CONSTRAINT FK_6F3856364D218E');
        $this->addSql('ALTER TABLE location_operator DROP CONSTRAINT FK_6F38563584598A3');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE location_operator');
        $this->addSql('DROP TABLE operator');
        $this->addSql('DROP TABLE "user"');
    }
}
