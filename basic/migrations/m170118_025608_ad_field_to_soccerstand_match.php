<?php

use yii\db\Migration;

class m170118_025608_ad_field_to_soccerstand_match extends Migration
{
    public function up()
    {

        $this->addColumn('{{soccerstand_match}}', 'match_id', 'INT(4)  DEFAULT 1');

        $this->createIndex("ux_soccerstand_match_match_id", 'soccerstand_match', "match_id", false);
        $this->db->createCommand('ALTER TABLE {{soccerstand_match}} ADD FOREIGN KEY (`match_id`) REFERENCES {{foo_matches}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m170118_025608_ad_field_to_soccerstand_match cannot be reverted.\n";

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
