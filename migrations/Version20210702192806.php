<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702192806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, rate DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles LONGTEXT NOT NULL, password VARCHAR(255) NOT NULL, nick VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_currency (user_id INT NOT NULL, currency_id INT NOT NULL, INDEX IDX_89DB6C3FA76ED395 (user_id), INDEX IDX_89DB6C3F38248176 (currency_id), PRIMARY KEY(user_id, currency_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_currency ADD CONSTRAINT FK_89DB6C3FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_currency ADD CONSTRAINT FK_89DB6C3F38248176 FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_currency DROP FOREIGN KEY FK_89DB6C3F38248176');
        $this->addSql('ALTER TABLE user_currency DROP FOREIGN KEY FK_89DB6C3FA76ED395');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_currency');
    }
}
