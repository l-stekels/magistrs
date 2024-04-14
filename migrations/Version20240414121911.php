<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414121911 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD hobbies JSON DEFAULT \'[]\' NOT NULL');
        $this->addSql('DROP INDEX unique_active_test');
        $this->addSql('ALTER TABLE test DROP active');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test ADD active BOOLEAN DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX unique_active_test ON test (active) WHERE (active IS TRUE)');
        $this->addSql('ALTER TABLE answer DROP hobbies');
    }
}
