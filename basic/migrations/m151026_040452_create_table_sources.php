<?php

use yii\db\Schema;
use yii\db\Migration;

class m151026_040452_create_table_sources extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{sources}}', array(
            'id' => 'pk',
            'title' => 'varchar(255) NOT NULL',
            'author_id' => 'INT(11) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_sources_sources_author_id", 'sources', "author_id", false);
        $this->db->createCommand('ALTER TABLE {{sources}} ADD FOREIGN KEY (`author_id`) REFERENCES {{authors}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();


    }

    public function down()
    {
        echo "m151026_040452_create_table_sources cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
