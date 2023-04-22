<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422125434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, account_number VARCHAR(255) DEFAULT NULL, balance DOUBLE PRECISION NOT NULL, INDEX IDX_7D3656A47E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trading (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, destination_account_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_BC19FB58E7DF2E9E (source_account_id), INDEX IDX_BC19FB58C652C408 (destination_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A47E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trading ADD CONSTRAINT FK_BC19FB58E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE trading ADD CONSTRAINT FK_BC19FB58C652C408 FOREIGN KEY (destination_account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading DROP FOREIGN KEY FK_BC19FB58E7DF2E9E');
        $this->addSql('ALTER TABLE trading DROP FOREIGN KEY FK_BC19FB58C652C408');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A47E3C61F9');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE trading');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
