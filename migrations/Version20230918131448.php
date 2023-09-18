<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918131448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C5C011B5');
        $this->addSql('DROP INDEX IDX_6A2CA10C5C011B5 ON media');
        $this->addSql('ALTER TABLE media CHANGE figure_id figure_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C6D69186E FOREIGN KEY (figure_id_id) REFERENCES figure (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C6D69186E ON media (figure_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C6D69186E');
        $this->addSql('DROP INDEX IDX_6A2CA10C6D69186E ON media');
        $this->addSql('ALTER TABLE media CHANGE figure_id_id figure_id INT NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6A2CA10C5C011B5 ON media (figure_id)');
    }
}
