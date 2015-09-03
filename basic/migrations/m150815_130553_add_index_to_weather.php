<?php

use yii\db\Schema;
use yii\db\Migration;

class m150815_130553_add_index_to_weather extends Migration
{
    public function up()
    {
        //$this->createIndex("ux_weather_city_id", '{{weather}}', "city_id", false);
        $this->db->createCommand('ALTER TABLE {{weather}} ADD FOREIGN KEY (`city_id`) REFERENCES  {{cities}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
    }



    public function down()
    {
        echo "m150815_130553_add_index_to_weather cannot be reverted.\n";

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
