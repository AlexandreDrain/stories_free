<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426132316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, story_id INT DEFAULT NULL, description LONGTEXT NOT NULL, liked INT DEFAULT NULL, disliked INT DEFAULT NULL, INDEX IDX_6970EB0FAA5D4036 (story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stories (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, liked INT NOT NULL, disliked INT NOT NULL, INDEX IDX_9C8B9D5FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags_stories (tags_id INT NOT NULL, stories_id INT NOT NULL, INDEX IDX_BA37764E8D7B4FB4 (tags_id), INDEX IDX_BA37764EBF2402DE (stories_id), PRIMARY KEY(tags_id, stories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, pseudo VARCHAR(255) NOT NULL, about_user LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FAA5D4036 FOREIGN KEY (story_id) REFERENCES stories (id)');
        $this->addSql('ALTER TABLE stories ADD CONSTRAINT FK_9C8B9D5FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tags_stories ADD CONSTRAINT FK_BA37764E8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_stories ADD CONSTRAINT FK_BA37764EBF2402DE FOREIGN KEY (stories_id) REFERENCES stories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FAA5D4036');
        $this->addSql('ALTER TABLE tags_stories DROP FOREIGN KEY FK_BA37764EBF2402DE');
        $this->addSql('ALTER TABLE tags_stories DROP FOREIGN KEY FK_BA37764E8D7B4FB4');
        $this->addSql('ALTER TABLE stories DROP FOREIGN KEY FK_9C8B9D5FA76ED395');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE stories');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE tags_stories');
        $this->addSql('DROP TABLE users');
    }
}
