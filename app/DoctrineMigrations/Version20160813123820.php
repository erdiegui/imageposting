<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160813123820 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE instagramConfig(
            id INT AUTO_INCREMENT NOT NULL,
            site_title VARCHAR (100) NOT NULL DEFAULT "", 
            views INT NOT NULL DEFAULT 0, 
            UNIQUE INDEX UNIQUE_IDENTIFIER (id),
            PRIMARY KEY(id))');

        $this->addSql('INSERT INTO instagramConfig (site_title, views) VALUES ("Welcome to instagramEd!", 0)');
        
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE instagramConfig');

    }
}
