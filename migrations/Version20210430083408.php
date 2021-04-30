<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430083408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor ADD doctor_complete_name VARCHAR(255) NOT NULL, ADD doctor_birth DATE NOT NULL, ADD doctor_phone VARCHAR(255) NOT NULL, ADD doctor_email VARCHAR(255) NOT NULL, ADD doctor_place VARCHAR(255) NOT NULL, ADD doctor_city VARCHAR(255) NOT NULL, ADD doctor_date_register DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor DROP doctor_complete_name, DROP doctor_birth, DROP doctor_phone, DROP doctor_email, DROP doctor_place, DROP doctor_city, DROP doctor_date_register');
    }
}
