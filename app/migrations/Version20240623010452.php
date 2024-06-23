<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623010452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adverts ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adverts ADD CONSTRAINT FK_8C88E777F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_8C88E777F675F31B ON adverts (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adverts DROP FOREIGN KEY FK_8C88E777F675F31B');
        $this->addSql('DROP INDEX IDX_8C88E777F675F31B ON adverts');
        $this->addSql('ALTER TABLE adverts DROP author_id');
    }
}
