<?php

use yii\db\Migration;

class m160906_010717_create_day_snapshot extends Migration
{
    public function up()
    {
        $this->createTable('day_snapshot', [
            'id' => $this->primaryKey(),
            'date' => 'DATE',
            'weight' => 'DECIMAL(10,2) DEFAULT 0',
            'doll' => 'DECIMAL(10,2) DEFAULT 0',
            'euro' => 'DECIMAL(10,2) DEFAULT 0',
            'oz' => 'INT(8) DEFAULT 0',
            'mish_oz' => 'INT(8) DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
    }

    public function down()
    {
        $this->dropTable('day_snapshot');
    }
}
