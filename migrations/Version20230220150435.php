<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220150435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor CHANGE cin cin BIGINT NOT NULL, CHANGE age age VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D61220EA6');
        $this->addSql('DROP INDEX IDX_5A8A6C8D61220EA6 ON post');
        $this->addSql('ALTER TABLE post CHANGE creator creator_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D61220EA6 ON post (creator_id)');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FE85F12B8');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55F9D86650F');
        $this->addSql('DROP INDEX IDX_A99CE55FE85F12B8 ON post_comment');
        $this->addSql('DROP INDEX IDX_A99CE55F9D86650F ON post_comment');
        $this->addSql('ALTER TABLE post_comment ADD post_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP post_id, DROP user_id');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FE85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A99CE55FE85F12B8 ON post_comment (post_id_id)');
        $this->addSql('CREATE INDEX IDX_A99CE55F9D86650F ON post_comment (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor CHANGE cin cin INT NOT NULL, CHANGE age age INT NOT NULL');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D61220EA6');
        $this->addSql('DROP INDEX IDX_5A8A6C8D61220EA6 ON post');
        $this->addSql('ALTER TABLE post CHANGE creator_id creator INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D61220EA6 FOREIGN KEY (creator) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D61220EA6 ON post (creator)');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FE85F12B8');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55F9D86650F');
        $this->addSql('DROP INDEX IDX_A99CE55FE85F12B8 ON post_comment');
        $this->addSql('DROP INDEX IDX_A99CE55F9D86650F ON post_comment');
        $this->addSql('ALTER TABLE post_comment ADD post_id INT NOT NULL, ADD user_id INT NOT NULL, DROP post_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FE85F12B8 FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55F9D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A99CE55FE85F12B8 ON post_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_A99CE55F9D86650F ON post_comment (user_id)');
    }
}
