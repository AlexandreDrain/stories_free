<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427132233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_stories (users_id INT NOT NULL, stories_id INT NOT NULL, INDEX IDX_6C8BE99567B3B43D (users_id), INDEX IDX_6C8BE995BF2402DE (stories_id), PRIMARY KEY(users_id, stories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_reviews (users_id INT NOT NULL, reviews_id INT NOT NULL, INDEX IDX_99709FC567B3B43D (users_id), INDEX IDX_99709FC58092D97F (reviews_id), PRIMARY KEY(users_id, reviews_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_stories ADD CONSTRAINT FK_6C8BE99567B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_stories ADD CONSTRAINT FK_6C8BE995BF2402DE FOREIGN KEY (stories_id) REFERENCES stories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_reviews ADD CONSTRAINT FK_99709FC567B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_reviews ADD CONSTRAINT FK_99709FC58092D97F FOREIGN KEY (reviews_id) REFERENCES reviews (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reviews ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F67B3B43D ON reviews (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_stories');
        $this->addSql('DROP TABLE users_reviews');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F67B3B43D');
        $this->addSql('DROP INDEX IDX_6970EB0F67B3B43D ON reviews');
        $this->addSql('ALTER TABLE reviews DROP users_id');
    }
}
