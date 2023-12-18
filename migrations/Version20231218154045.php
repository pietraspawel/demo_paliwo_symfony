<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218154045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE odometer (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, value INT NOT NULL, fuel NUMERIC(5, 2) DEFAULT NULL, price NUMERIC(11, 2) DEFAULT NULL, date DATE NOT NULL, INDEX IDX_729143B4C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE odometer ADD CONSTRAINT FK_729143B4C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE car CHANGE active active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE odometer');
        $this->addSql('ALTER TABLE car CHANGE active active TINYINT(1) DEFAULT 1 NOT NULL');
    }
}
