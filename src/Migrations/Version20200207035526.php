<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200207035526 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE transaction_compte');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F720B9C8 FOREIGN KEY (comptes_env_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1342A7271 FOREIGN KEY (comptes_ret_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D1F720B9C8 ON transaction (comptes_env_id)');
        $this->addSql('CREATE INDEX IDX_723705D1342A7271 ON transaction (comptes_ret_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transaction_compte (transaction_id INT NOT NULL, compte_id INT NOT NULL, INDEX IDX_B98B2020F2C56620 (compte_id), INDEX IDX_B98B20202FC0CB0F (transaction_id), PRIMARY KEY(transaction_id, compte_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction_compte ADD CONSTRAINT FK_B98B20202FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_compte ADD CONSTRAINT FK_B98B2020F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F720B9C8');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1342A7271');
        $this->addSql('DROP INDEX IDX_723705D1F720B9C8 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1342A7271 ON transaction');
    }
}
