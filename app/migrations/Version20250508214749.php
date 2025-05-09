<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250508214749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'H-2: Creates cities, countries, weather tables.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE cities (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                country_id SMALLINT UNSIGNED DEFAULT NULL,
                name VARCHAR(50) NOT NULL,
                INDEX IDX_D95DB16BF92F3E70 (country_id),
                INDEX IDX__name (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE countries (
                id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(50) NOT NULL,
                PRIMARY KEY(id)
           ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE weather (
                id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                city_id INT UNSIGNED DEFAULT NULL,
                temperature NUMERIC(5, 1) NOT NULL,
                conditions VARCHAR(255) NOT NULL,
                humidity SMALLINT NOT NULL,
                wind_speed NUMERIC(5, 1) NOT NULL,
                last_updated DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                INDEX IDX__city (city_id),
                PRIMARY KEY(id)
             ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE messenger_messages (
                id BIGINT AUTO_INCREMENT NOT NULL,
                body LONGTEXT NOT NULL,
                headers LONGTEXT NOT NULL,
                queue_name VARCHAR(190) NOT NULL,
                created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
                INDEX IDX_75EA56E0FB7336F0 (queue_name),
                INDEX IDX_75EA56E0E3BD61CE (available_at),
                INDEX IDX_75EA56E016BA31DB (delivered_at),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
        SQL);
        $this->addSql(<<<SQL
            ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id);
        SQL);
        $this->addSql(<<<SQL
            ALTER TABLE weather ADD CONSTRAINT FK_4CD0D36E8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id);
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BF92F3E70;
        SQL);
        $this->addSql(<<<SQL
            ALTER TABLE weather DROP FOREIGN KEY FK_4CD0D36E8BAC62AF;
        SQL);
        $this->addSql(<<<SQL
            DROP TABLE cities;
        SQL);
        $this->addSql(<<<SQL
            DROP TABLE countries;
        SQL);
        $this->addSql(<<<SQL
            DROP TABLE weather;
        SQL);
        $this->addSql(<<<SQL
            DROP TABLE messenger_messages;
        SQL);
    }
}
