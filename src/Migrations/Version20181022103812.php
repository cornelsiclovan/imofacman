<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181022103812 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity_log (id INT AUTO_INCREMENT NOT NULL, staff_id INT DEFAULT NULL, intern TINYINT(1) NOT NULL, log VARCHAR(255) NOT NULL, duration DOUBLE PRECISION NOT NULL, details VARCHAR(255) DEFAULT NULL, lunch_break VARCHAR(255) DEFAULT NULL, published_at DATE NOT NULL, INDEX IDX_FD06F647D4D57CD (staff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_log_owner (activity_log_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_8062A96B811BD86 (activity_log_id), INDEX IDX_8062A967E3C61F9 (owner_id), PRIMARY KEY(activity_log_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_log_property (activity_log_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_EC191540B811BD86 (activity_log_id), INDEX IDX_EC191540549213EC (property_id), PRIMARY KEY(activity_log_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_8BF21CDE7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, staff_type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', UNIQUE INDEX UNIQ_426EF392E7927C74 (email), INDEX IDX_426EF39299FA9B25 (staff_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, add_data_for VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_log ADD CONSTRAINT FK_FD06F647D4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id)');
        $this->addSql('ALTER TABLE activity_log_owner ADD CONSTRAINT FK_8062A96B811BD86 FOREIGN KEY (activity_log_id) REFERENCES activity_log (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_log_owner ADD CONSTRAINT FK_8062A967E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540B811BD86 FOREIGN KEY (activity_log_id) REFERENCES activity_log (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_log_property ADD CONSTRAINT FK_EC191540549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF39299FA9B25 FOREIGN KEY (staff_type_id) REFERENCES staff_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_log_owner DROP FOREIGN KEY FK_8062A96B811BD86');
        $this->addSql('ALTER TABLE activity_log_property DROP FOREIGN KEY FK_EC191540B811BD86');
        $this->addSql('ALTER TABLE activity_log_property DROP FOREIGN KEY FK_EC191540549213EC');
        $this->addSql('ALTER TABLE activity_log_owner DROP FOREIGN KEY FK_8062A967E3C61F9');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE7E3C61F9');
        $this->addSql('ALTER TABLE activity_log DROP FOREIGN KEY FK_FD06F647D4D57CD');
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF39299FA9B25');
        $this->addSql('DROP TABLE activity_log');
        $this->addSql('DROP TABLE activity_log_owner');
        $this->addSql('DROP TABLE activity_log_property');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE staff_type');
    }
}
