<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321113806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, id_borrow_id INT DEFAULT NULL, id_box_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, isbn INT NOT NULL, is_available TINYINT(1) NOT NULL, cover VARCHAR(255) NOT NULL, resume LONGTEXT NOT NULL, INDEX IDX_CBE5A33154F5BAEF (id_borrow_id), INDEX IDX_CBE5A331FE20CED2 (id_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_category (book_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_1FB30F9816A2B381 (book_id), INDEX IDX_1FB30F9812469DE2 (category_id), PRIMARY KEY(book_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE borrow (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, date_borrow DATE NOT NULL, date_return DATE NOT NULL, INDEX IDX_55DBA8B079F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE box (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, zipcode INT NOT NULL, city VARCHAR(255) NOT NULL, geo_loc LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', capacity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33154F5BAEF FOREIGN KEY (id_borrow_id) REFERENCES borrow (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331FE20CED2 FOREIGN KEY (id_box_id) REFERENCES box (id)');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9816A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B079F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33154F5BAEF');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331FE20CED2');
        $this->addSql('ALTER TABLE book_category DROP FOREIGN KEY FK_1FB30F9816A2B381');
        $this->addSql('ALTER TABLE book_category DROP FOREIGN KEY FK_1FB30F9812469DE2');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B079F37AE5');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_category');
        $this->addSql('DROP TABLE borrow');
        $this->addSql('DROP TABLE box');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE user');
    }
}
