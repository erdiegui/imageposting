<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160811141113 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE images (
            id INT AUTO_INCREMENT NOT NULL, 
            title VARCHAR (100) NOT NULL,
            image_file VARCHAR(255) NOT NULL, 
            views INT NOT NULL, 
            UNIQUE INDEX UNIQUE_IDENTIFIER (id),
            PRIMARY KEY(id))');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE images');
    }
}
