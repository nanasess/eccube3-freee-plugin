<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151220235032 extends AbstractMigration
{
    const NAME = 'plg_freee_tax';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable(self::NAME);
        $table->addColumn('code', 'integer', array(
            'unsigned' => true
        ));
        $table->addColumn('name', 'text', array('notnull' => false));
        $table->addColumn('name_ja', 'text', array('notnull' => false));
        $table->setPrimaryKey(array('code'));
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
