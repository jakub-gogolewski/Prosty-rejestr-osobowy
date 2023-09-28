<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928163033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses ADD persons_key_id INT NOT NULL');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF19255278607620 FOREIGN KEY (persons_key_id) REFERENCES persons (id)');
        $this->addSql('CREATE INDEX IDX_EF19255278607620 ON adresses (persons_key_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF19255278607620');
        $this->addSql('DROP INDEX IDX_EF19255278607620 ON adresses');
        $this->addSql('ALTER TABLE adresses DROP persons_key_id');
    }
}
