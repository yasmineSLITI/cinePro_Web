<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410094508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE followingproduit ADD id INT AUTO_INCREMENT NOT NULL, CHANGE IDProduit IDProduit INT DEFAULT NULL, CHANGE idClient idClient INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE followingproduit ADD CONSTRAINT FK_F8D70F97429B6720 FOREIGN KEY (IDProduit) REFERENCES produit (IDProduit)');
        $this->addSql('ALTER TABLE followingproduit ADD CONSTRAINT FK_F8D70F97A455ACCF FOREIGN KEY (idClient) REFERENCES client (idClient)');
        $this->addSql('DROP INDEX fk2 ON followingproduit');
        $this->addSql('CREATE INDEX IDX_F8D70F97429B6720 ON followingproduit (IDProduit)');
        $this->addSql('DROP INDEX fk ON followingproduit');
        $this->addSql('CREATE INDEX IDX_F8D70F97A455ACCF ON followingproduit (idClient)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE followingproduit MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE followingproduit DROP FOREIGN KEY FK_F8D70F97429B6720');
        $this->addSql('ALTER TABLE followingproduit DROP FOREIGN KEY FK_F8D70F97A455ACCF');
        $this->addSql('ALTER TABLE followingproduit DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE followingproduit DROP FOREIGN KEY FK_F8D70F97429B6720');
        $this->addSql('ALTER TABLE followingproduit DROP FOREIGN KEY FK_F8D70F97A455ACCF');
        $this->addSql('ALTER TABLE followingproduit DROP id, CHANGE IDProduit IDProduit INT NOT NULL, CHANGE idClient idClient INT NOT NULL');
        $this->addSql('ALTER TABLE followingproduit ADD PRIMARY KEY (IDProduit, idClient)');
        $this->addSql('DROP INDEX idx_f8d70f97429b6720 ON followingproduit');
        $this->addSql('CREATE INDEX FK2 ON followingproduit (IDProduit)');
        $this->addSql('DROP INDEX idx_f8d70f97a455accf ON followingproduit');
        $this->addSql('CREATE INDEX fk ON followingproduit (idClient)');
        $this->addSql('ALTER TABLE followingproduit ADD CONSTRAINT FK_F8D70F97429B6720 FOREIGN KEY (IDProduit) REFERENCES produit (IDProduit)');
        $this->addSql('ALTER TABLE followingproduit ADD CONSTRAINT FK_F8D70F97A455ACCF FOREIGN KEY (idClient) REFERENCES client (idClient)');
    }
}
