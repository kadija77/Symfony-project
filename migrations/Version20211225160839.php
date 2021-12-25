<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225160839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, coefficient INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot_travail (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, travail_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, note DOUBLE PRECISION DEFAULT NULL, INDEX IDX_83AD362AA76ED395 (user_id), INDEX IDX_83AD362AEEFE7EA9 (travail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travail (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, INDEX IDX_90897ABB12469DE2 (category_id), INDEX IDX_90897ABBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, type enum(\'etudiant\',\'enseignant\'), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depot_travail ADD CONSTRAINT FK_83AD362AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE depot_travail ADD CONSTRAINT FK_83AD362AEEFE7EA9 FOREIGN KEY (travail_id) REFERENCES travail (id)');
        $this->addSql('ALTER TABLE travail ADD CONSTRAINT FK_90897ABB12469DE2 FOREIGN KEY (category_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE travail ADD CONSTRAINT FK_90897ABBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE travail DROP FOREIGN KEY FK_90897ABB12469DE2');
        $this->addSql('ALTER TABLE depot_travail DROP FOREIGN KEY FK_83AD362AEEFE7EA9');
        $this->addSql('ALTER TABLE depot_travail DROP FOREIGN KEY FK_83AD362AA76ED395');
        $this->addSql('ALTER TABLE travail DROP FOREIGN KEY FK_90897ABBA76ED395');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE depot_travail');
        $this->addSql('DROP TABLE travail');
        $this->addSql('DROP TABLE user');
    }
}
