<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409085619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, email INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet CHANGE IDBillet IDBillet INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE idPanier idPanier INT DEFAULT 1');
        $this->addSql('ALTER TABLE facture RENAME INDEX idpanier TO Ordre_fk');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK2');
        $this->addSql('ALTER TABLE panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier CHANGE idProduit idProduit INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF2391C87D5 ON panier (idProduit)');
        $this->addSql('ALTER TABLE panier ADD PRIMARY KEY (idPanier)');
        $this->addSql('ALTER TABLE produit CHANGE IDProduit IDProduit INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adresse');
        $this->addSql('ALTER TABLE billet CHANGE IDBillet IDBillet INT NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE idPanier idPanier INT NOT NULL');
        $this->addSql('ALTER TABLE facture RENAME INDEX ordre_fk TO idPanier');
        $this->addSql('DROP INDEX UNIQ_24CC0DF2391C87D5 ON panier');
        $this->addSql('ALTER TABLE panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier CHANGE idProduit idProduit INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK2 FOREIGN KEY (idClient) REFERENCES client (idClient) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE panier ADD PRIMARY KEY (idPanier, idProduit)');
        $this->addSql('ALTER TABLE produit CHANGE IDProduit IDProduit INT NOT NULL');
    }
}
