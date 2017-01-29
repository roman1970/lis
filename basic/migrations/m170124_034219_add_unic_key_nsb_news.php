<?php

use yii\db\Migration;

class m170124_034219_add_unic_key_nsb_news extends Migration
{
    public function up()
    {
        $this->createIndex("ux_nsb_news_guid", 'nsb_news', "guid", false);
       // $this->db->createCommand('ALTER TABLE {{nsb_news}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{nsb_news}} ADD UNIQUE INDEX `ix_guid` (guid);')->execute();


    }

    public function down()
    {
        echo "m170124_034219_add_unic_key_nsb_news cannot be reverted.\n";

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
