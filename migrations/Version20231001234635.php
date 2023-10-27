<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231001234635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE adresses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE persons_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adresses (id INT NOT NULL, persons_key_id INT NOT NULL, postal VARCHAR(6) NOT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, street_number VARCHAR(50) NOT NULL, flat_number VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EF19255278607620 ON adresses (persons_key_id)');
        $this->addSql('CREATE TABLE persons (id INT NOT NULL, name VARCHAR(100) NOT NULL, surname VARCHAR(150) NOT NULL, age SMALLINT NOT NULL, sex VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF19255278607620 FOREIGN KEY (persons_key_id) REFERENCES persons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE adresses_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE persons_id_seq CASCADE');
        $this->addSql('ALTER TABLE adresses DROP CONSTRAINT FK_EF19255278607620');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE persons');
    }
}
