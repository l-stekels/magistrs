<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407140541 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ALTER threshold DROP NOT NULL');
        $this->addSql('ALTER TABLE answer ALTER wheel_emotion DROP NOT NULL');
        $this->addSql('ALTER TABLE answer ALTER wheel_score DROP NOT NULL');
        $this->addSql('ALTER TABLE answer ALTER is_mobile DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ALTER threshold SET NOT NULL');
        $this->addSql('ALTER TABLE answer ALTER wheel_emotion SET NOT NULL');
        $this->addSql('ALTER TABLE answer ALTER wheel_score SET NOT NULL');
        $this->addSql('ALTER TABLE answer ALTER is_mobile SET DEFAULT false');
    }
}
