<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210427063642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD numero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F5D172A78 FOREIGN KEY (numero_id) REFERENCES `references` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB988C6F5D172A78 ON annonces (numero_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F5D172A78');
        $this->addSql('DROP INDEX UNIQ_CB988C6F5D172A78 ON annonces');
        $this->addSql('ALTER TABLE annonces DROP numero_id');
    }
}
