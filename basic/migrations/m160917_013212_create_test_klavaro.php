<?php

use yii\db\Migration;

class m160917_013212_create_test_klavaro extends Migration
{
    public function up()
    {
        $this->createTable('test_klavaro', [
            'id' => $this->primaryKey(),
            'presize' => 'DECIMAL(10,2) DEFAULT 0',
            'eng_ru' => 'VARCHAR(255) NOT NULL',
            'speed' => 'DECIMAL(10,2) DEFAULT 0',
            'cat_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_test_klavaro_cat_id", 'test_klavaro', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{test_klavaro}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        $this->dropTable('test_klavaro');
    }
}
