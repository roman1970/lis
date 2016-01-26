<?php

use yii\db\Migration;

class m160126_103754_create_khl_matches_tbl extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{chl_matches}}', array(
            'id' => 'pk',
            'host_id' => 'INT(2) NOT NULL',
            'guest_id' => 'INT(2) NOT NULL',
            'host_g' => 'INT(2) NOT NULL',
            'guest_g' => 'INT(2) NOT NULL',
            'prim' => 'varchar(255) NOT NULL'
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_chl_matches_host_id", '{{chl_matches}}', "host_id", false);
        $this->createIndex("ux_chl_matches_guest_id", '{{chl_matches}}', "guest_id", false);

        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`host_id`) REFERENCES  {{chl_teams}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`guest_id`) REFERENCES  {{chl_teams}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
    }

    public function down()
    {
        echo "m160126_103754_create_khl_matches_tbl cannot be reverted.\n";

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
