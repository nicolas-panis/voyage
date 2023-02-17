<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217174409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC617C4B2B0');
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC6A76ED395');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('ALTER TABLE commentaires CHANGE articles_id articles_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, commentaires_id INT NOT NULL, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_1E512EC6A76ED395 (user_id), INDEX IDX_1E512EC617C4B2B0 (commentaires_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC617C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES commentaires (id)');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires CHANGE articles_id articles_id INT NOT NULL');
    }
}
