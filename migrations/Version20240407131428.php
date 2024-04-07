<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407131428 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id UUID NOT NULL, test_id UUID NOT NULL, gender VARCHAR(255) NOT NULL, age INT NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, threshold INT NOT NULL, wheel_emotion VARCHAR(255) NOT NULL, wheel_score INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A251E5D0459 ON answer (test_id)');
        $this->addSql('COMMENT ON COLUMN answer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer.test_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer.completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN answer.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN answer.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE test (id UUID NOT NULL, active BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX unique_active_test ON test (active) WHERE (active IS TRUE)');
        $this->addSql('COMMENT ON COLUMN test.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN test.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN test.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A251E5D0459');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE test');
    }
}
