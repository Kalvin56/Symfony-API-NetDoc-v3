<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522161537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, appointment_patient_id INT DEFAULT NULL, appointment_doctor_id INT DEFAULT NULL, appointment_date DATE NOT NULL, appointment_time TIME NOT NULL, appointment_duration INT NOT NULL, appointment_take_datetime DATETIME DEFAULT NULL, appointment_status INT NOT NULL, INDEX IDX_FE38F84412C0A0B3 (appointment_patient_id), INDEX IDX_FE38F844127E951E (appointment_doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84412C0A0B3 FOREIGN KEY (appointment_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844127E951E FOREIGN KEY (appointment_doctor_id) REFERENCES doctor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointment');
    }
}
