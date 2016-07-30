<?php

use yii\db\Migration;

class m160730_034542_create_foo_team extends Migration
{
    public function up()
    {
        $this->createTable('foo_team', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
            'tournament_id' => 'INT(4) NOT NULL',
            'mem' => 'INT(8) NOT NULL',
            'play' => 'INT(8) NOT NULL',
            'vic' => 'INT(8) NOT NULL',
            'nob' => 'INT(8) NOT NULL',
            'def' => 'INT(8) NOT NULL',
            'goal_g' => 'INT(8) NOT NULL',
            'goal_l' => 'INT(8) NOT NULL',
            'balls' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_foo_team_tournament_id", 'foo_team', "tournament_id", false);
        $this->db->createCommand('ALTER TABLE {{foo_team}} ADD FOREIGN KEY (`tournament_id`) REFERENCES  {{foo_tournament}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('foo_team');
    }
}
