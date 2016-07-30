<?php

use yii\db\Migration;

class m160730_025927_create_foo_tournament extends Migration
{
    public function up()
    {
        $this->createTable('foo_tournament', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'country_id' => 'INT(4)  DEFAULT 236',
            ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_foo_tournament_country_id", 'foo_tournament', "country_id", false);
        $this->db->createCommand('ALTER TABLE {{foo_tournament}} ADD FOREIGN KEY (`country_id`) REFERENCES  {{country}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        $this->dropTable('foo_tournament');
    }
}
