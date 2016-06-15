<?php

use yii\db\Migration;

class m160615_030344_create_tbl_tag extends Migration
{
    public function up()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'frequency' => 'INT(11) NOT NULL',
            ],
            'DEFAULT CHARSET=utf8 ENGINE = INNODB');
    }

    public function down()
    {
        $this->dropTable('tag');
    }
}
