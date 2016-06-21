<?php

use yii\db\Migration;

class m160621_033625_create_tot_match extends Migration
{
    public function up()
    {

        $this->createTable('tot_match', [
            'id' => $this->primaryKey(),
            'date' => 'VARCHAR(255) NOT NULL',
            'host' => 'VARCHAR(255) NOT NULL',
            'guest' => 'VARCHAR(255) NOT NULL',
            'tournament' => 'VARCHAR(255) NOT NULL',
            'foo_match_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_tot_match_foo_match_id", 'tot_match', "foo_match_id", false);
        $this->db->createCommand('ALTER TABLE {{tot_match}} ADD FOREIGN KEY (`foo_match_id`) REFERENCES  {{foo_matches}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('tot_match');
    }
}
