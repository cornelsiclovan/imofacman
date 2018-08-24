<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180823094714 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE staff_type ADD add_data_for VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE activity_log CHANGE staff_id staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staff CHANGE staff_type_id staff_type_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_log CHANGE staff_id staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staff CHANGE staff_type_id staff_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staff_type DROP add_data_for');
    }
}
