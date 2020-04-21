<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204175507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affect_compte ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE affect_compte ADD CONSTRAINT FK_728C576867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_728C576867B3B43D ON affect_compte (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affect_compte DROP FOREIGN KEY FK_728C576867B3B43D');
        $this->addSql('DROP INDEX IDX_728C576867B3B43D ON affect_compte');
        $this->addSql('ALTER TABLE affect_compte DROP users_id');
    }
}
