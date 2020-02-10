<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200208122536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F720B9C8 FOREIGN KEY (comptes_env_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1342A7271 FOREIGN KEY (comptes_ret_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D1F720B9C8 ON transaction (comptes_env_id)');
        $this->addSql('CREATE INDEX IDX_723705D1342A7271 ON transaction (comptes_ret_id)');
        $this->addSql('ALTER TABLE partenaire ADD contrat_id INT NOT NULL');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA3731823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32FFA3731823061F ON partenaire (contrat_id)');
        $this->addSql('ALTER TABLE affect_compte CHANGE date_debut date_debut DATETIME DEFAULT NULL, CHANGE date_fin date_fin DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affect_compte CHANGE date_debut date_debut DATE DEFAULT NULL, CHANGE date_fin date_fin DATE NOT NULL');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA3731823061F');
        $this->addSql('DROP INDEX UNIQ_32FFA3731823061F ON partenaire');
        $this->addSql('ALTER TABLE partenaire DROP contrat_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F720B9C8');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1342A7271');
        $this->addSql('DROP INDEX IDX_723705D1F720B9C8 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1342A7271 ON transaction');
    }
}
