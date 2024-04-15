<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415063352 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_d87f7e0ccfed4fbf');
        $this->addSql('ALTER TABLE test DROP short_identifier');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test ADD short_identifier VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_d87f7e0ccfed4fbf ON test (short_identifier)');
    }
}
