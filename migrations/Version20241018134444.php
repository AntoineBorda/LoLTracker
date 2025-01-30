<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018134444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ally (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, data_champion_id INT DEFAULT NULL, team_position VARCHAR(20) DEFAULT NULL, selected TINYINT(1) DEFAULT NULL, INDEX IDX_382900DE48FD905 (game_id), INDEX IDX_382900D5BF88A1 (data_champion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_champion (id INT NOT NULL, name VARCHAR(50) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_country (id VARCHAR(255) NOT NULL, common VARCHAR(255) DEFAULT NULL, official VARCHAR(255) DEFAULT NULL, cca2 VARCHAR(3) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, flag VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_item (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_league (id BIGINT UNSIGNED NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, priority INT DEFAULT NULL, position INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_perk (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, tooltip LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_queue (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, short_name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_summoner (id BIGINT UNSIGNED NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_team (id BIGINT UNSIGNED NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, alternative_image VARCHAR(255) DEFAULT NULL, background_image VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, home_league_name VARCHAR(255) DEFAULT NULL, home_league_region VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, tracker_id INT DEFAULT NULL, data_queue_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', lpvar INT DEFAULT NULL, score_rank INT DEFAULT NULL, match_id VARCHAR(50) DEFAULT NULL, end_of_game_result VARCHAR(50) DEFAULT NULL, game_creation BIGINT DEFAULT NULL, game_duration INT DEFAULT NULL, game_mode VARCHAR(20) DEFAULT NULL, game_type VARCHAR(20) DEFAULT NULL, game_version VARCHAR(50) DEFAULT NULL, map_id INT DEFAULT NULL, assists INT DEFAULT NULL, baron_kills INT DEFAULT NULL, bounty_level INT DEFAULT NULL, champ_level INT DEFAULT NULL, deaths INT DEFAULT NULL, double_kills INT DEFAULT NULL, eligible_for_progression TINYINT(1) DEFAULT NULL, first_blood_kill TINYINT(1) DEFAULT NULL, gold_earned INT DEFAULT NULL, kills INT DEFAULT NULL, longest_time_spent_living INT DEFAULT NULL, neutral_minions_killed INT DEFAULT NULL, penta_kills INT DEFAULT NULL, quadra_kills INT DEFAULT NULL, team_position VARCHAR(10) DEFAULT NULL, time_ccing_others INT DEFAULT NULL, total_damage_dealt_to_champions INT DEFAULT NULL, total_damage_taken INT DEFAULT NULL, total_minions_killed INT DEFAULT NULL, total_time_spent_dead INT DEFAULT NULL, triple_kills INT DEFAULT NULL, vision_score INT DEFAULT NULL, win TINYINT(1) DEFAULT NULL, bounty_gold INT DEFAULT NULL, damage_per_minute DOUBLE PRECISION DEFAULT NULL, early_laning_phase_gold_exp_advantage INT DEFAULT NULL, flawless_aces INT DEFAULT NULL, gold_per_minute DOUBLE PRECISION DEFAULT NULL, kda DOUBLE PRECISION DEFAULT NULL, kill_participation DOUBLE PRECISION DEFAULT NULL, lane_minions_first10_minutes INT DEFAULT NULL, laning_phase_gold_exp_advantage INT DEFAULT NULL, max_cs_advantage_on_lane_opponent INT DEFAULT NULL, max_level_lead_lane_opponent INT DEFAULT NULL, skillshots_dodged INT DEFAULT NULL, team_damage_percentage DOUBLE PRECISION DEFAULT NULL, turret_plates_taken INT DEFAULT NULL, turret_takedowns INT DEFAULT NULL, vision_score_advantage_lane_opponent DOUBLE PRECISION DEFAULT NULL, vision_score_per_minute DOUBLE PRECISION DEFAULT NULL, tier VARCHAR(20) DEFAULT NULL, rank VARCHAR(4) DEFAULT NULL, league_points INT DEFAULT NULL, wins INT DEFAULT NULL, losses INT DEFAULT NULL, veteran TINYINT(1) DEFAULT NULL, inactive TINYINT(1) DEFAULT NULL, fresh_blood TINYINT(1) DEFAULT NULL, hot_streak TINYINT(1) DEFAULT NULL, INDEX IDX_232B318CFB5230B (tracker_id), INDEX IDX_232B318C8DA59272 (data_queue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, data_item_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_1F1B251EE48FD905 (game_id), INDEX IDX_1F1B251E766404AF (data_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`, data_league_id BIGINT UNSIGNED DEFAULT NULL, INDEX IDX_3EB4C31899E6F5DF (player_id), INDEX IDX_3EB4C318D70084E8 (data_league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opponent (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, data_champion_id INT DEFAULT NULL, team_position VARCHAR(20) DEFAULT NULL, selected TINYINT(1) DEFAULT NULL, INDEX IDX_A9322AFFE48FD905 (game_id), INDEX IDX_A9322AFF5BF88A1 (data_champion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perk (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, data_perk_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_C30ED5EFE48FD905 (game_id), INDEX IDX_C30ED5EFBB0318C2 (data_perk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pick (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, data_champion_id INT DEFAULT NULL, INDEX IDX_99CD0F9BE48FD905 (game_id), INDEX IDX_99CD0F9B5BF88A1 (data_champion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id VARCHAR(255) NOT NULL COLLATE `utf8_bin`, country_id VARCHAR(255) DEFAULT NULL, owner_id INT DEFAULT NULL, id_riot BIGINT UNSIGNED DEFAULT NULL, summoner_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, twitch VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_98197A65995999EB (id_riot), INDEX IDX_98197A65F92F3E70 (country_id), INDEX IDX_98197A657E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE riot_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`, game_name VARCHAR(255) DEFAULT NULL, tag_line VARCHAR(255) DEFAULT NULL, puuid VARCHAR(255) DEFAULT NULL, summoner_id VARCHAR(255) DEFAULT NULL, account_id VARCHAR(255) DEFAULT NULL, profile_icon_id INT DEFAULT NULL, revision_date BIGINT DEFAULT NULL, summoner_level INT DEFAULT NULL, INDEX IDX_4A3B81E7A76ED395 (user_id), INDEX IDX_4A3B81E799E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE summoner (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, data_summoner_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_ABE89763E48FD905 (game_id), INDEX IDX_ABE8976343C1993F (data_summoner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`, data_team_id BIGINT UNSIGNED DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, INDEX IDX_C4E0A61F99E6F5DF (player_id), INDEX IDX_C4E0A61F4D678E5F (data_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tracker (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, riot_info_id INT DEFAULT NULL, player_id VARCHAR(255) DEFAULT NULL COLLATE `utf8_bin`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', visible TINYINT(1) DEFAULT NULL, INDEX IDX_AC632AAFA76ED395 (user_id), INDEX IDX_AC632AAF597F4371 (riot_info_id), INDEX IDX_AC632AAF99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE twitch_info (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, login VARCHAR(255) DEFAULT NULL, display_name VARCHAR(255) DEFAULT NULL, profile_image_url VARCHAR(255) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, INDEX IDX_E744CBF7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ally ADD CONSTRAINT FK_382900DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE ally ADD CONSTRAINT FK_382900D5BF88A1 FOREIGN KEY (data_champion_id) REFERENCES data_champion (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CFB5230B FOREIGN KEY (tracker_id) REFERENCES tracker (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C8DA59272 FOREIGN KEY (data_queue_id) REFERENCES data_queue (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E766404AF FOREIGN KEY (data_item_id) REFERENCES data_item (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C31899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318D70084E8 FOREIGN KEY (data_league_id) REFERENCES data_league (id)');
        $this->addSql('ALTER TABLE opponent ADD CONSTRAINT FK_A9322AFFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE opponent ADD CONSTRAINT FK_A9322AFF5BF88A1 FOREIGN KEY (data_champion_id) REFERENCES data_champion (id)');
        $this->addSql('ALTER TABLE perk ADD CONSTRAINT FK_C30ED5EFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE perk ADD CONSTRAINT FK_C30ED5EFBB0318C2 FOREIGN KEY (data_perk_id) REFERENCES data_perk (id)');
        $this->addSql('ALTER TABLE pick ADD CONSTRAINT FK_99CD0F9BE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE pick ADD CONSTRAINT FK_99CD0F9B5BF88A1 FOREIGN KEY (data_champion_id) REFERENCES data_champion (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65F92F3E70 FOREIGN KEY (country_id) REFERENCES data_country (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A657E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE riot_info ADD CONSTRAINT FK_4A3B81E7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE riot_info ADD CONSTRAINT FK_4A3B81E799E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE summoner ADD CONSTRAINT FK_ABE89763E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE summoner ADD CONSTRAINT FK_ABE8976343C1993F FOREIGN KEY (data_summoner_id) REFERENCES data_summoner (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F4D678E5F FOREIGN KEY (data_team_id) REFERENCES data_team (id)');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAFA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAF597F4371 FOREIGN KEY (riot_info_id) REFERENCES riot_info (id)');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAF99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE twitch_info ADD CONSTRAINT FK_E744CBF7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ally DROP FOREIGN KEY FK_382900DE48FD905');
        $this->addSql('ALTER TABLE ally DROP FOREIGN KEY FK_382900D5BF88A1');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CFB5230B');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C8DA59272');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EE48FD905');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E766404AF');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C31899E6F5DF');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318D70084E8');
        $this->addSql('ALTER TABLE opponent DROP FOREIGN KEY FK_A9322AFFE48FD905');
        $this->addSql('ALTER TABLE opponent DROP FOREIGN KEY FK_A9322AFF5BF88A1');
        $this->addSql('ALTER TABLE perk DROP FOREIGN KEY FK_C30ED5EFE48FD905');
        $this->addSql('ALTER TABLE perk DROP FOREIGN KEY FK_C30ED5EFBB0318C2');
        $this->addSql('ALTER TABLE pick DROP FOREIGN KEY FK_99CD0F9BE48FD905');
        $this->addSql('ALTER TABLE pick DROP FOREIGN KEY FK_99CD0F9B5BF88A1');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65F92F3E70');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A657E3C61F9');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE riot_info DROP FOREIGN KEY FK_4A3B81E7A76ED395');
        $this->addSql('ALTER TABLE riot_info DROP FOREIGN KEY FK_4A3B81E799E6F5DF');
        $this->addSql('ALTER TABLE summoner DROP FOREIGN KEY FK_ABE89763E48FD905');
        $this->addSql('ALTER TABLE summoner DROP FOREIGN KEY FK_ABE8976343C1993F');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F99E6F5DF');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F4D678E5F');
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAFA76ED395');
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAF597F4371');
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAF99E6F5DF');
        $this->addSql('ALTER TABLE twitch_info DROP FOREIGN KEY FK_E744CBF7A76ED395');
        $this->addSql('DROP TABLE ally');
        $this->addSql('DROP TABLE data_champion');
        $this->addSql('DROP TABLE data_country');
        $this->addSql('DROP TABLE data_item');
        $this->addSql('DROP TABLE data_league');
        $this->addSql('DROP TABLE data_perk');
        $this->addSql('DROP TABLE data_queue');
        $this->addSql('DROP TABLE data_summoner');
        $this->addSql('DROP TABLE data_team');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE opponent');
        $this->addSql('DROP TABLE perk');
        $this->addSql('DROP TABLE pick');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE riot_info');
        $this->addSql('DROP TABLE summoner');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE tracker');
        $this->addSql('DROP TABLE twitch_info');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
