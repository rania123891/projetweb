<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410204754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE typevehicule (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (immatriculation VARCHAR(255) NOT NULL, type_vehicule_id INT NOT NULL, marque VARCHAR(255) NOT NULL, puissance VARCHAR(255) NOT NULL, kilometrage VARCHAR(255) NOT NULL, nbrdeplace INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_292FFF1D153E280 (type_vehicule_id), PRIMARY KEY(immatriculation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D153E280 FOREIGN KEY (type_vehicule_id) REFERENCES typevehicule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D153E280');
        $this->addSql('DROP TABLE typevehicule');
        $this->addSql('DROP TABLE vehicule');
    }
}
