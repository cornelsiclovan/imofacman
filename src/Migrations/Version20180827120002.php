<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180827120002 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_log CHANGE staff_id staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staff CHANGE staff_type_id staff_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity_log_property DROP FOREIGN KEY FK_EC191540549213EC');
        $this->addSql('ALTER TABLE activity_log_property DROP FOREIGN KEY FK_EC191540B811BD86');
        $this->addSql('ALTER TABLE activity_log_property DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE activity_log_property ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540B811BD86 FOREIGN KEY (activity_log_id) REFERENCES activity_log (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_log CHANGE staff_id staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity_log_property MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE activity_log_property DROP FOREIGN KEY FK_EC191540B811BD86');
        $this->addSql('ALTER TABLE activity_log_property DROP FOREIGN KEY FK_EC191540549213EC');
        $this->addSql('ALTER TABLE activity_log_property DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE activity_log_property DROP id');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540B811BD86 FOREIGN KEY (activity_log_id) REFERENCES activity_log (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_log_property ADD PRIMARY KEY (activity_log_id, property_id)');
        $this->addSql('ALTER TABLE property CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staff CHANGE staff_type_id staff_type_id INT DEFAULT NULL');
    }
}
