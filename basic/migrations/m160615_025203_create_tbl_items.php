<?php

use yii\db\Migration;

class m160615_025203_create_tbl_items extends Migration
{
    public function up()
    {
        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'source_id' => 'INT(11) NOT NULL',
            'text' => 'TEXT NOT NULL',
            'tags' => 'VARCHAR(255) NOT NULL',
            'audio' => 'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_items_source_id", 'items', "source_id", false);
        $this->db->createCommand('ALTER TABLE {{items}} ADD FOREIGN KEY (`source_id`) REFERENCES  {{sources}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('tbl_items');
    }
}
