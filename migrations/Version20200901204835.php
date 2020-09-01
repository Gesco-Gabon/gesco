<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901204835 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location_operator (location_id INT NOT NULL, operator_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_6F3856364D218E (location_id), INDEX IDX_6F38563584598A3 (operator_id), PRIMARY KEY(location_id, operator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_operator ADD CONSTRAINT FK_6F3856364D218E FOREIGN KEY (location_id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_operator ADD CONSTRAINT FK_6F38563584598A3 FOREIGN KEY (operator_id) REFERENCES operator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD current TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE operator DROP FOREIGN KEY FK_D7A6A78164D218E');
        $this->addSql('DROP INDEX IDX_D7A6A78164D218E ON operator');
        $this->addSql('ALTER TABLE operator DROP location_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE location_operator');
        $this->addSql('ALTER TABLE location DROP current');
        $this->addSql('ALTER TABLE operator ADD location_id INT NOT NULL');
        $this->addSql('ALTER TABLE operator ADD CONSTRAINT FK_D7A6A78164D218E FOREIGN KEY (location_id) REFERENCES location (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D7A6A78164D218E ON operator (location_id)');
    }
}
