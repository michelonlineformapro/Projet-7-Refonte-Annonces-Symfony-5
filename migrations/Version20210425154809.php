<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425154809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD nom_categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F2E4CAE29 FOREIGN KEY (nom_categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6F2E4CAE29 ON annonces (nom_categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F2E4CAE29');
        $this->addSql('DROP INDEX IDX_CB988C6F2E4CAE29 ON annonces');
        $this->addSql('ALTER TABLE annonces DROP nom_categories_id');
    }
}
