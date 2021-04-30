<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430082002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A9D86650F');
        $this->addSql('DROP INDEX UNIQ_1FC0F36A9D86650F ON doctor');
        $this->addSql('ALTER TABLE doctor CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FC0F36AA76ED395 ON doctor (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36AA76ED395');
        $this->addSql('DROP INDEX UNIQ_1FC0F36AA76ED395 ON doctor');
        $this->addSql('ALTER TABLE doctor CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FC0F36A9D86650F ON doctor (user_id_id)');
    }
}
