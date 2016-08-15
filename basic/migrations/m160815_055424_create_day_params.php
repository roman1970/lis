<?php

use yii\db\Migration;

class m160815_055424_create_day_params extends Migration
{
    public function up()
    {
        $this->createTable('day_params', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
    }

    public function down()
    {
        $this->dropTable('day_params');
    }
}
