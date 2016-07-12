<?php

use yii\db\Migration;

class m160712_022937_create_played extends Migration
{
    public function up()
    {
        $this->createTable('played', [
            'id' => $this->primaryKey(),
            'source_id' => 'INT(11) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_played_source_id", 'played', "source_id", false);
        $this->db->createCommand('ALTER TABLE {{played}} ADD FOREIGN KEY (`source_id`) REFERENCES  {{sources}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('played');
    }
}
