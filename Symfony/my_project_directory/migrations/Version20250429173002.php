<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429173002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE borrowing (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, reader_id INT NOT NULL, borrow_date DATETIME NOT NULL, return_date DATETIME DEFAULT NULL, INDEX IDX_226E589716A2B381 (book_id), INDEX IDX_226E58971717D737 (reader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE borrowing ADD CONSTRAINT FK_226E589716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE borrowing ADD CONSTRAINT FK_226E58971717D737 FOREIGN KEY (reader_id) REFERENCES reader (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE borrowing DROP FOREIGN KEY FK_226E589716A2B381
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE borrowing DROP FOREIGN KEY FK_226E58971717D737
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE borrowing
        SQL);
    }
}
