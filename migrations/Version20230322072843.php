<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322072843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_etablissement (utilisateur_id INT NOT NULL, etablissement_id INT NOT NULL, INDEX IDX_42008AEFB88E14F (utilisateur_id), INDEX IDX_42008AEFF631228 (etablissement_id), PRIMARY KEY(utilisateur_id, etablissement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_etablissement ADD CONSTRAINT FK_42008AEFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_etablissement ADD CONSTRAINT FK_42008AEFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_etablissement DROP FOREIGN KEY FK_42008AEFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_etablissement DROP FOREIGN KEY FK_42008AEFF631228');
        $this->addSql('DROP TABLE utilisateur_etablissement');
    }
}
