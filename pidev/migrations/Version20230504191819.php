<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504191819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9A76ED395 FOREIGN KEY (user_id) REFERENCES `utilisateur` (id)');
        $this->addSql('CREATE INDEX IDX_64C19AA9A76ED395 ON agence (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9A76ED395');
        $this->addSql('DROP INDEX IDX_64C19AA9A76ED395 ON agence');
        $this->addSql('ALTER TABLE agence DROP user_id');
    }
}
