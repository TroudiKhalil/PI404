<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220152301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor DROP nom, DROP prenom, DROP cin, DROP email, DROP adresse, DROP age, DROP mdp');
        $this->addSql('ALTER TABLE post ADD id_doctor_id INT DEFAULT NULL, CHANGE creator_id creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D7C14730 FOREIGN KEY (id_doctor_id) REFERENCES doctor (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D7C14730 ON post (id_doctor_id)');
        $this->addSql('ALTER TABLE reclamation ADD id_doctor_id INT DEFAULT NULL, CHANGE id_user_id id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047C14730 FOREIGN KEY (id_doctor_id) REFERENCES doctor (id)');
        $this->addSql('CREATE INDEX IDX_CE6064047C14730 ON reclamation (id_doctor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD cin BIGINT NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD age VARCHAR(255) NOT NULL, ADD mdp VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D7C14730');
        $this->addSql('DROP INDEX IDX_5A8A6C8D7C14730 ON post');
        $this->addSql('ALTER TABLE post DROP id_doctor_id, CHANGE creator_id creator_id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047C14730');
        $this->addSql('DROP INDEX IDX_CE6064047C14730 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP id_doctor_id, CHANGE id_user_id id_user_id INT NOT NULL');
    }
}
