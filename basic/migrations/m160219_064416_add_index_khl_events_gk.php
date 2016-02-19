<?php

use yii\db\Migration;

class m160219_064416_add_index_khl_events_gk extends Migration
{
    public function up()
    {
        $this->createIndex("ux_chl_events_gk", '{{chl_events}}', "gk", false);

        $this->db->createCommand('ALTER TABLE {{chl_events}} ADD FOREIGN KEY (`gk`) REFERENCES  {{chl_players}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m160219_064416_add_index_khl_events_gk cannot be reverted.\n";

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
