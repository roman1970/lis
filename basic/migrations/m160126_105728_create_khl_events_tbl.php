<?php

use yii\db\Migration;

class m160126_105728_create_khl_events_tbl extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{chl_events}}', array(
            'id' => 'pk',
            'minute' => 'INT(255) NOT NULL',
            'player_id' => 'INT(8) NOT NULL',
            'match_id' => 'INT(8) NOT NULL',
            'status' => 'INT(2) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_chl_events_player_id", '{{chl_events}}', "player_id", false);
        $this->createIndex("ux_chl_events_match_id", '{{chl_events}}', "match_id", false);

        $this->db->createCommand('ALTER TABLE {{chl_events}} ADD FOREIGN KEY (`player_id`) REFERENCES  {{chl_players}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_events}} ADD FOREIGN KEY (`match_id`) REFERENCES  {{chl_matches}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m160126_105728_create_khl_events_tbl cannot be reverted.\n";

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
