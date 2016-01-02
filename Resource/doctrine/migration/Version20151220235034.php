<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151220235034 extends AbstractMigration
{
    const NAME = 'plg_freee_company';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable(self::NAME);
        $table->addColumn('id', 'integer', array(
            'unsigned' => true
        ));
        $table->addColumn('name', 'text', array('notnull' => false));
        $table->addColumn('name_kana', 'text', array('notnull' => false));
        $table->addColumn('display_name', 'text', array('notnull' => false));
        $table->addColumn('role', 'text', array('notnull' => false));
        $table->setPrimaryKey(array('id'));
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
