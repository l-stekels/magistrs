<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416060641 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD gew_emotions JSON DEFAULT \'[]\' NOT NULL');
        $this->addSql('ALTER TABLE answer DROP wheel_emotion');
        $this->addSql('ALTER TABLE answer DROP wheel_score');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD wheel_emotion VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE answer ADD wheel_score INT DEFAULT NULL');
        $this->addSql('ALTER TABLE answer DROP gew_emotions');
    }
}
