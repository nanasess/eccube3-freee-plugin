<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151220235031 extends AbstractMigration
{
    const NAME = 'plg_freee_oauth2';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable(self::NAME);
        $table->addColumn('freee_oauth2_id', 'integer', array(
            'unsigned' => true
        ));
        $table->addColumn('access_token', 'text', array('notnull' => false));
        $table->addColumn('token_type', 'text', array('notnull' => false));
        $table->addColumn('expires_in', 'integer', array('notnull' => false));
        $table->addColumn('refresh_token', 'text', array('notnull' => false));
        $table->addColumn('scope', 'text', array('notnull' => false));
        $table->addColumn('update_date', 'datetime', array('notnull' => false));
        $table->setPrimaryKey(array('freee_oauth2_id'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        if (!$schema->hasTable(self::NAME)) {
            return true;
        }
        $schema->dropTable(self::NAME);
    }
}
