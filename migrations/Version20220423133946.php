<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423133946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, bck_color VARCHAR(7) NOT NULL, brd_cloro VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet CHANGE created_on created_on DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk4000');
        $this->addSql('ALTER TABLE client CHANGE DateNaiss DateNaiss DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455586CA949 FOREIGN KEY (userName) REFERENCES compte (userName)');
        $this->addSql('ALTER TABLE demandedesponsoring DROP FOREIGN KEY fk96');
        $this->addSql('ALTER TABLE demandedesponsoring DROP FOREIGN KEY fk56');
        $this->addSql('ALTER TABLE demandedesponsoring DROP FOREIGN KEY fk56');
        $this->addSql('ALTER TABLE demandedesponsoring CHANGE idSp idSp INT DEFAULT NULL, CHANGE etatAccept etatAccept VARCHAR(255) DEFAULT \'\'\'En attente\'\'\' NOT NULL, CHANGE idEv IdEv INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demandedesponsoring ADD CONSTRAINT FK_894B8B90BCEEC41E FOREIGN KEY (IdEv) REFERENCES evenement (IdEv)');
        $this->addSql('ALTER TABLE demandedesponsoring ADD CONSTRAINT FK_894B8B90E9277BC2 FOREIGN KEY (idSp) REFERENCES sponsor (idSp)');
        $this->addSql('DROP INDEX fk56 ON demandedesponsoring');
        $this->addSql('CREATE INDEX fk7899 ON demandedesponsoring (idEv)');
        $this->addSql('ALTER TABLE demandedesponsoring ADD CONSTRAINT fk56 FOREIGN KEY (idEv) REFERENCES evenement (IdEv) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY Fk1000000');
        $this->addSql('ALTER TABLE evenement CHANGE NumRea NumRea INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E31E9BE2C FOREIGN KEY (NumRea) REFERENCES realisateur (NumRea)');
        $this->addSql('ALTER TABLE facture CHANGE DateCreation DateCreation DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK400');
        $this->addSql('ALTER TABLE film CHANGE Archive Archive TINYINT(1) NOT NULL, CHANGE EtatAcc EtatAcc VARCHAR(255) DEFAULT \'\'\'en attente\'\'\' NOT NULL, CHANGE dateDispo dateDispo DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE2231E9BE2C FOREIGN KEY (NumRea) REFERENCES realisateur (NumRea)');
        $this->addSql('ALTER TABLE presse CHANGE badgeAttribue badgeAttribue TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE Image Image VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE publication CHANGE imgPub imgPub VARCHAR(255) DEFAULT \'NULL\', CHANGE txtPub txtPub VARCHAR(255) DEFAULT \'NULL\', CHANGE dateCreationPub dateCreationPub DATETIME DEFAULT \'current_timestamp()\' NOT NULL, CHANGE archive archive TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk9000');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk1200');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY fk1000');
        $this->addSql('ALTER TABLE reservation CHANGE idF idF INT DEFAULT NULL, CHANGE DateDeb DateDeb VARCHAR(255) DEFAULT \'\'\'20-02-2022\'\'\', CHANGE DateFin DateFin VARCHAR(255) DEFAULT \'NULL\', CHANGE idSa idSa INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551CDC6B20 FOREIGN KEY (idEv) REFERENCES evenement (IdEv)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955266963BB FOREIGN KEY (idF) REFERENCES film (idF)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495583975B30 FOREIGN KEY (idSa) REFERENCES salle (idSa)');
        $this->addSql('ALTER TABLE salle CHANGE enMaintenance enMaintenance TINYINT(1) NOT NULL, CHANGE disponible disponible VARCHAR(255) DEFAULT \'\'\'En maintenance\'\'\' NOT NULL');
        $this->addSql('ALTER TABLE signale CHANGE nbreSignal nbreSignal INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calendar');
        $this->addSql('ALTER TABLE billet CHANGE created_on created_on DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455586CA949');
        $this->addSql('ALTER TABLE client CHANGE DateNaiss DateNaiss DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk4000 FOREIGN KEY (userName) REFERENCES compte (userName) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demandedesponsoring DROP FOREIGN KEY FK_894B8B90BCEEC41E');
        $this->addSql('ALTER TABLE demandedesponsoring DROP FOREIGN KEY FK_894B8B90E9277BC2');
        $this->addSql('ALTER TABLE demandedesponsoring DROP FOREIGN KEY FK_894B8B90BCEEC41E');
        $this->addSql('ALTER TABLE demandedesponsoring CHANGE etatAccept etatAccept VARCHAR(255) DEFAULT \'En attente\' NOT NULL, CHANGE IdEv idEv INT NOT NULL, CHANGE idSp idSp INT NOT NULL');
        $this->addSql('ALTER TABLE demandedesponsoring ADD CONSTRAINT fk96 FOREIGN KEY (idSp) REFERENCES sponsor (idSp) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demandedesponsoring ADD CONSTRAINT fk56 FOREIGN KEY (idEv) REFERENCES evenement (IdEv) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX fk7899 ON demandedesponsoring');
        $this->addSql('CREATE INDEX fk56 ON demandedesponsoring (idEv)');
        $this->addSql('ALTER TABLE demandedesponsoring ADD CONSTRAINT FK_894B8B90BCEEC41E FOREIGN KEY (IdEv) REFERENCES evenement (IdEv)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E31E9BE2C');
        $this->addSql('ALTER TABLE evenement CHANGE NumRea NumRea INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT Fk1000000 FOREIGN KEY (NumRea) REFERENCES realisateur (NumRea) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture CHANGE DateCreation DateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE2231E9BE2C');
        $this->addSql('ALTER TABLE film CHANGE Archive Archive TINYINT(1) DEFAULT 0 NOT NULL, CHANGE EtatAcc EtatAcc VARCHAR(255) DEFAULT \'en attente\' NOT NULL, CHANGE dateDispo dateDispo DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK400 FOREIGN KEY (NumRea) REFERENCES realisateur (NumRea) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE presse CHANGE badgeAttribue badgeAttribue TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE Image Image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE publication CHANGE imgPub imgPub VARCHAR(255) DEFAULT NULL, CHANGE txtPub txtPub VARCHAR(255) DEFAULT NULL, CHANGE dateCreationPub dateCreationPub DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE archive archive TINYINT(1) DEFAULT 0');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551CDC6B20');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955266963BB');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495583975B30');
        $this->addSql('ALTER TABLE reservation CHANGE DateDeb DateDeb VARCHAR(255) DEFAULT \'20-02-2022\', CHANGE DateFin DateFin VARCHAR(255) DEFAULT NULL, CHANGE idF idF INT NOT NULL, CHANGE idSa idSa INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk9000 FOREIGN KEY (idSa) REFERENCES salle (idSa) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk1200 FOREIGN KEY (idEv) REFERENCES evenement (IdEv) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk1000 FOREIGN KEY (idF) REFERENCES film (idF) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle CHANGE enMaintenance enMaintenance TINYINT(1) DEFAULT 0 NOT NULL, CHANGE disponible disponible VARCHAR(255) DEFAULT \'En maintenance\' NOT NULL');
        $this->addSql('ALTER TABLE signale CHANGE nbreSignal nbreSignal INT DEFAULT 0 NOT NULL');
    }
}
