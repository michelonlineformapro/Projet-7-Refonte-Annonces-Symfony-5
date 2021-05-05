<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425105808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces ADD categorie_annonce_id INT DEFAULT NULL, ADD region_annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F16CC6183 FOREIGN KEY (categorie_annonce_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6FA9E29FCE FOREIGN KEY (region_annonce_id) REFERENCES regions (id)');
        $this->addSql('CREATE INDEX IDX_CB988C6F16CC6183 ON annonces (categorie_annonce_id)');
        $this->addSql('CREATE INDEX IDX_CB988C6FA9E29FCE ON annonces (region_annonce_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F16CC6183');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6FA9E29FCE');
        $this->addSql('DROP INDEX IDX_CB988C6F16CC6183 ON annonces');
        $this->addSql('DROP INDEX IDX_CB988C6FA9E29FCE ON annonces');
        $this->addSql('ALTER TABLE annonces DROP categorie_annonce_id, DROP region_annonce_id');
    }
}
