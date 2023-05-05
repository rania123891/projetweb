<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504191547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, nom_ag VARCHAR(255) NOT NULL, nombre_ag VARCHAR(255) NOT NULL, ref_ag VARCHAR(255) NOT NULL, email_ag VARCHAR(255) NOT NULL, adresse_ag VARCHAR(255) NOT NULL, ville_ag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, vehicule_immatriculation VARCHAR(10) DEFAULT NULL, date_res DATE NOT NULL, heure_res TIME NOT NULL, method_p VARCHAR(255) NOT NULL, duree_loc VARCHAR(255) NOT NULL, nom_loc VARCHAR(255) NOT NULL, cin_loc VARCHAR(255) NOT NULL, INDEX IDX_42C849559F8DBDBC (vehicule_immatriculation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typevehicule (id INT AUTO_INCREMENT NOT NULL, agence_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_75467195D725330D (agence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `utilisateur` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', mdp VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, num INT NOT NULL, adresse VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, rate INT NOT NULL, type VARCHAR(255) NOT NULL, verified VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (immatriculation VARCHAR(10) NOT NULL, type_vehicule_id INT NOT NULL, marque VARCHAR(255) NOT NULL, puissance VARCHAR(255) NOT NULL, kilometrage VARCHAR(255) NOT NULL, nbrdeplace INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_292FFF1D153E280 (type_vehicule_id), PRIMARY KEY(immatriculation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559F8DBDBC FOREIGN KEY (vehicule_immatriculation) REFERENCES vehicule (immatriculation)');
        $this->addSql('ALTER TABLE typevehicule ADD CONSTRAINT FK_75467195D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D153E280 FOREIGN KEY (type_vehicule_id) REFERENCES typevehicule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559F8DBDBC');
        $this->addSql('ALTER TABLE typevehicule DROP FOREIGN KEY FK_75467195D725330D');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D153E280');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE typevehicule');
        $this->addSql('DROP TABLE `utilisateur`');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
