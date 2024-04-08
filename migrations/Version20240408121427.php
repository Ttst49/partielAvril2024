<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408121427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP CONSTRAINT fk_d34a04ad6db2eb0');
        $this->addSql('DROP INDEX uniq_d34a04ad6db2eb0');
        $this->addSql('ALTER TABLE product RENAME COLUMN image_file_id TO image_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD3DA5256D ON product (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD3DA5256D');
        $this->addSql('DROP INDEX UNIQ_D34A04AD3DA5256D');
        $this->addSql('ALTER TABLE product RENAME COLUMN image_id TO image_file_id');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT fk_d34a04ad6db2eb0 FOREIGN KEY (image_file_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_d34a04ad6db2eb0 ON product (image_file_id)');
    }
}
