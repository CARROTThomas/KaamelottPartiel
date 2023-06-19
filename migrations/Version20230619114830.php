<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619114830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE citation_user (citation_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(citation_id, user_id))');
        $this->addSql('CREATE INDEX IDX_4217C294500A8AB7 ON citation_user (citation_id)');
        $this->addSql('CREATE INDEX IDX_4217C294A76ED395 ON citation_user (user_id)');
        $this->addSql('ALTER TABLE citation_user ADD CONSTRAINT FK_4217C294500A8AB7 FOREIGN KEY (citation_id) REFERENCES citation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE citation_user ADD CONSTRAINT FK_4217C294A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE citation DROP CONSTRAINT fk_fabd9c7ef675f31b');
        $this->addSql('DROP INDEX idx_fabd9c7ef675f31b');
        $this->addSql('ALTER TABLE citation DROP author_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE citation_user DROP CONSTRAINT FK_4217C294500A8AB7');
        $this->addSql('ALTER TABLE citation_user DROP CONSTRAINT FK_4217C294A76ED395');
        $this->addSql('DROP TABLE citation_user');
        $this->addSql('ALTER TABLE citation ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE citation ADD CONSTRAINT fk_fabd9c7ef675f31b FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fabd9c7ef675f31b ON citation (author_id)');
    }
}
