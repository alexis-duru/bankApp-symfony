<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420164636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7D3656A47E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__account AS SELECT id, owner_id, balance, account_number FROM account');
        $this->addSql('DROP TABLE account');
        $this->addSql('CREATE TABLE account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, balance DOUBLE PRECISION NOT NULL, account_number VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_7D3656A47E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO account (id, owner_id, balance, account_number) SELECT id, owner_id, balance, account_number FROM __temp__account');
        $this->addSql('DROP TABLE __temp__account');
        $this->addSql('CREATE INDEX IDX_7D3656A47E3C61F9 ON account (owner_id)');
        $this->addSql('DROP INDEX IDX_BC19FB58C652C408');
        $this->addSql('DROP INDEX IDX_BC19FB58E7DF2E9E');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trading AS SELECT id, source_account_id, destination_account_id, amount, description FROM trading');
        $this->addSql('DROP TABLE trading');
        $this->addSql('CREATE TABLE trading (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, source_account_id INTEGER DEFAULT NULL, destination_account_id INTEGER DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_BC19FB58E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BC19FB58C652C408 FOREIGN KEY (destination_account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO trading (id, source_account_id, destination_account_id, amount, description) SELECT id, source_account_id, destination_account_id, amount, description FROM __temp__trading');
        $this->addSql('DROP TABLE __temp__trading');
        $this->addSql('CREATE INDEX IDX_BC19FB58C652C408 ON trading (destination_account_id)');
        $this->addSql('CREATE INDEX IDX_BC19FB58E7DF2E9E ON trading (source_account_id)');
        $this->addSql('DROP INDEX IDX_75EA56E016BA31DB');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0');
        $this->addSql('CREATE TEMPORARY TABLE __temp__messenger_messages AS SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM messenger_messages');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL COLLATE BINARY, headers CLOB NOT NULL COLLATE BINARY, queue_name VARCHAR(190) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM __temp__messenger_messages');
        $this->addSql('DROP TABLE __temp__messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7D3656A47E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__account AS SELECT id, owner_id, account_number, balance FROM account');
        $this->addSql('DROP TABLE account');
        $this->addSql('CREATE TABLE account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, account_number VARCHAR(255) DEFAULT NULL, balance DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO account (id, owner_id, account_number, balance) SELECT id, owner_id, account_number, balance FROM __temp__account');
        $this->addSql('DROP TABLE __temp__account');
        $this->addSql('CREATE INDEX IDX_7D3656A47E3C61F9 ON account (owner_id)');
        $this->addSql('DROP INDEX IDX_BC19FB58E7DF2E9E');
        $this->addSql('DROP INDEX IDX_BC19FB58C652C408');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trading AS SELECT id, source_account_id, destination_account_id, amount, description FROM trading');
        $this->addSql('DROP TABLE trading');
        $this->addSql('CREATE TABLE trading (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, source_account_id INTEGER DEFAULT NULL, destination_account_id INTEGER DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, transaction_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO trading (id, source_account_id, destination_account_id, amount, description) SELECT id, source_account_id, destination_account_id, amount, description FROM __temp__trading');
        $this->addSql('DROP TABLE __temp__trading');
        $this->addSql('CREATE INDEX IDX_BC19FB58E7DF2E9E ON trading (source_account_id)');
        $this->addSql('CREATE INDEX IDX_BC19FB58C652C408 ON trading (destination_account_id)');
    }
}
