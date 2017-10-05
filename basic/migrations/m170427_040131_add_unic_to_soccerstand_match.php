<?php

use yii\db\Migration;

class m170427_040131_add_unic_to_soccerstand_match extends Migration
{
    public function up()
    {
        //$this->createIndex("ux_soccerstand_match", 'soccerstand_match', "aa_ad", false);
        $this->db->createCommand('ALTER TABLE {{soccerstand_match}} ADD UNIQUE INDEX `ux_aa_ad` (aa, ad);')->execute();

    }

    public function down()
    {
        echo "m170427_040131_add_unic_to_soccerstand_match cannot be reverted.\n";

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
