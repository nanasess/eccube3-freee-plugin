<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151220235030 extends AbstractMigration
{
    const NAME = 'plg_freeelight';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable(self::NAME);
        $table->addColumn('freee_id', 'integer', array(
            'unsigned' => true
        ));
        $table->addColumn('client_id', 'text', array('notnull' => false));
        $table->addColumn('client_secret', 'text', array('notnull' => false));
        $table->addColumn('company_id', 'integer', array('notnull' => false));
        $table->setPrimaryKey(array('freee_id'));
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
