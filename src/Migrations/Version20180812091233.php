<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180812091233 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity_log_property (activity_log_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_EC191540B811BD86 (activity_log_id), INDEX IDX_EC191540549213EC (property_id), PRIMARY KEY(activity_log_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540B811BD86 FOREIGN KEY (activity_log_id) REFERENCES activity_log (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE activity_log_property');
    }
}
