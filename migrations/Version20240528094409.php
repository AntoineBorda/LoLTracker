<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528094409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league CHANGE player_id player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`');
        $this->addSql('ALTER TABLE player CHANGE id id VARCHAR(255) NOT NULL COLLATE `utf8_bin`');
        $this->addSql('ALTER TABLE riot_info CHANGE player_id player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`');
        $this->addSql('ALTER TABLE team ADD is_active TINYINT(1) DEFAULT NULL, CHANGE player_id player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`');
        $this->addSql('ALTER TABLE tracker CHANGE player_id player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tracker CHANGE player_id player_id VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`');
        $this->addSql('ALTER TABLE player CHANGE id id VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_bin`');
        $this->addSql('ALTER TABLE team DROP is_active, CHANGE player_id player_id VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`');
        $this->addSql('ALTER TABLE league CHANGE player_id player_id VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`');
        $this->addSql('ALTER TABLE riot_info CHANGE player_id player_id VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_bin`');
    }
}
