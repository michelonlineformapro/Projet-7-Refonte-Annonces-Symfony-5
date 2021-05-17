<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511085139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, annonces_id INT DEFAULT NULL, auteurs VARCHAR(255) NOT NULL, contenus LONGTEXT NOT NULL, date_poste DATETIME NOT NULL, INDEX IDX_D9BEC0C44C2885D7 (annonces_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C44C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id)');
        $this->addSql('ALTER TABLE annonces ADD utilisateurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F1E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6F1E969C5 ON annonces (utilisateurs_id)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_CB988C6F5ED249E6 ON annonces (nom_annonces)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F1E969C5');
        $this->addSql('DROP INDEX IDX_CB988C6F1E969C5 ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6F5ED249E6 ON annonces');
        $this->addSql('ALTER TABLE annonces DROP utilisateurs_id');
    }
}
