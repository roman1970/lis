<?php

use yii\db\Migration;

class m160126_105121_create_khl_players_tbl extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{chl_players}}', array(
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
            'team_id' => 'INT(2) NOT NULL',
            'status' => 'INT(2) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_chl_players_team_id", '{{chl_players}}', "team_id", false);

        $this->db->createCommand('ALTER TABLE {{chl_players}} ADD FOREIGN KEY (`team_id`) REFERENCES  {{chl_teams}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m160126_105121_create_khl_players_tbl cannot be reverted.\n";

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
