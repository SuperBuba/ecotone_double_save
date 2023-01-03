<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230103071703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE merchants (id BLOB NOT NULL --(DC2Type:ulid)
        , name VARCHAR(180) DEFAULT NULL, owner_user_id BLOB DEFAULT NULL --(DC2Type:ulid)
        , owner_email VARCHAR(180) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id BLOB NOT NULL --(DC2Type:ulid)
        , email VARCHAR(180) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE merchants');
        $this->addSql('DROP TABLE users');
    }
}
