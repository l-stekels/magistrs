<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416064802 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id UUID NOT NULL, test_id UUID NOT NULL, gender VARCHAR(255) NOT NULL, age INT NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, threshold INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_mobile BOOLEAN NOT NULL, walker_emotion VARCHAR(255) DEFAULT NULL, custom_emotion VARCHAR(255) DEFAULT NULL, guessed_emotion VARCHAR(255) DEFAULT NULL, hobbies JSON DEFAULT \'[]\' NOT NULL, education VARCHAR(255) DEFAULT NULL, gew_emotions JSON DEFAULT \'[]\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_dadd4a251e5d0459 ON answer (test_id)');
        $this->addSql('COMMENT ON COLUMN answer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer.test_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer.completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN answer.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN answer.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_email ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE test (id UUID NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_eye_tracking BOOLEAN NOT NULL, is_shared BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN test.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN test.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN test.updated_at IS \'(DC2Type:datetime_immutable)\'');
        // Seed users
        $this->addSql('INSERT INTO "user" (id, email, password, roles) VALUES (:id, :email, :password, :roles)', [
            'id' => 'f568d6e2-4769-46bd-9302-5227f4e9bb26',
            'email' => 'admin@stekels.lv',
            'password' => '$2y$13$gKMJF2PxQFw3VcCrLgLM0uO5rHnAxsc7wb48Q7bkiX0YOyPdybDS.',
            'roles' => '["ROLE_ADMIN"]',
        ], [
            'id' => 'uuid',
        ]);
        $this->addSql('INSERT INTO "user" (id, email, password, roles) VALUES (:id, :email, :password, :roles)', [
            'id' => 'e2dda968-8049-4fb3-8ebc-2271ee7ac752',
            'email' => 'manager@stekels.lv',
            'password' => '$2y$13$BD0lKnTPcejjR.rOwU2uu.DqpcneXYKQrwoVWExwUTxfHX6QaHF52',
            'roles' => '["ROLE_MANAGER"]',
        ], [
            'id' => 'uuid',
        ]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE test');
    }
}
