<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414182408 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO "user" (id, email, password, roles) VALUES (:id, :email, :password, :roles)', [
            'id' => 'f568d6e2-4769-46bd-9302-5227f4e9bb26',
            'email' => 'admin@stekels.lv',
            'password' => '$2y$13$7onioPJKROWGhqxLoyB.qOz8U3DoYr3Tk6gE3sSAvpZCMxC9yjtP.',
            'roles' => '["ROLE_ADMIN"]',
        ], [
            'id' => 'uuid',
        ]);
        $this->addSql('INSERT INTO "user" (id, email, password, roles) VALUES (:id, :email, :password, :roles)', [
            'id' => 'e2dda968-8049-4fb3-8ebc-2271ee7ac752',
            'email' => 'manager@stekels.lv',
            'password' => '$2y$13$7ejV8ADHg5hEI7JwZfMB6uK5ZcyyuEbnPB9lokOXrjDAV25bUwYly',
            'roles' => '["ROLE_MANAGER"]',
        ], [
            'id' => 'uuid',
        ]);
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM "user" WHERE id in (\'f568d6e2-4769-46bd-9302-5227f4e9bb26\', \'e2dda968-8049-4fb3-8ebc-2271ee7ac752\')');
    }
}
