<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Uid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407132752 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO test (id, active, title, created_at) VALUES (:id, true, \'Test 1\', now())', [
            'id' => Uuid::fromString('d87f7e0c-4b1e-fc02-8b1e-4f7e8c02d87f'),
        ], [
            'id' => 'uuid',
        ]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM test WHERE id = :id', [
            'id' => Uuid::fromString('d87f7e0c-4b1e-fc02-8b1e-4f7e8c02d87f'),
        ], [
            'id' => 'uuid',
        ]);
    }
}
