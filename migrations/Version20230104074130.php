<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104074130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, created_at DATE NOT NULL, updated_up DATETIME NOT NULL, actif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE etablissement CHANGE numero_tel numero_tel VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE update_at update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE ville CHANGE code_postal code_postal VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE categorie CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE etablissement CHANGE numero_tel numero_tel VARCHAR(14) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATE NOT NULL, CHANGE update_at update_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE ville CHANGE code_postal code_postal INT NOT NULL');
    }
}
