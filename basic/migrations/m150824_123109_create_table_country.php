<?php

use yii\db\Schema;
use yii\db\Migration;

class m150824_123109_create_table_country extends Migration
{
    public function up()
    {
       /* $this->createTable(
            '{{country}}', array(
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_cities_country_id", '{{cities}}', "country_id", false);
        */

        $this->db->createCommand('ALTER TABLE {{cities}} ADD FOREIGN KEY (`country_id`) REFERENCES  {{country}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        echo "m150824_123109_create_table_country cannot be reverted.\n";

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
