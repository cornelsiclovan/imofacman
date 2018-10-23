<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181022121633 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_log CHANGE staff_id staff_id INT DEFAULT NULL, CHANGE details details VARCHAR(255) DEFAULT NULL, CHANGE lunch_break lunch_break VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staff CHANGE staff_type_id staff_type_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE activity_type');
        $this->addSql('ALTER TABLE activity_log CHANGE staff_id staff_id INT DEFAULT NULL, CHANGE details details VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE lunch_break lunch_break VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE property CHANGE owner_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staff CHANGE staff_type_id staff_type_id INT DEFAULT NULL');
    }
}
