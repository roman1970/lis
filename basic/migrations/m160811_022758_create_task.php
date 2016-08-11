<?php

use yii\db\Migration;

class m160811_022758_create_task extends Migration
{
    public function up()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
            'description' => 'varchar(255) NOT NULL',
            'status' => 'INT(4) DEFAULT 0 COMMENT "0 - ежедневные, 1 - разовые"',
            'hour' => 'INT(10) DEFAULT 0',
            'dead_line' => 'INT(10) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        $this->dropTable('task');
    }
}
