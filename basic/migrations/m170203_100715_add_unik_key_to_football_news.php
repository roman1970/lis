<?php

use yii\db\Migration;

class m170203_100715_add_unik_key_to_football_news extends Migration
{
    public function up()
    {
        $this->createIndex("ux_football_news_guid", 'nsb_news', "guid", false);
        // $this->db->createCommand('ALTER TABLE {{nsb_news}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{football_news}} ADD UNIQUE INDEX `ix_guid` (guid);')->execute();

    }

    public function down()
    {
        echo "m170203_100715_add_unik_key_to_football_news cannot be reverted.\n";

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
