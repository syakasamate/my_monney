<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200128032247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partenaire ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA37367B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32FFA37367B3B43D ON partenaire (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA37367B3B43D');
        $this->addSql('DROP INDEX UNIQ_32FFA37367B3B43D ON partenaire');
        $this->addSql('ALTER TABLE partenaire DROP users_id');
    }
}
