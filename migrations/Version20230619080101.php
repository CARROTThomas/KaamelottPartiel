<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619080101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE citation ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE citation ADD caractere TEXT NOT NULL');
        $this->addSql('ALTER TABLE citation DROP author');
        $this->addSql('ALTER TABLE citation ADD CONSTRAINT FK_FABD9C7EF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FABD9C7EF675F31B ON citation (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE citation DROP CONSTRAINT FK_FABD9C7EF675F31B');
        $this->addSql('DROP INDEX IDX_FABD9C7EF675F31B');
        $this->addSql('ALTER TABLE citation ADD author VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE citation DROP author_id');
        $this->addSql('ALTER TABLE citation DROP caractere');
    }
}
