<?php

use yii\db\Migration;

class m160807_024611_create_dish extends Migration
{
    public function up()
    {
        $this->createTable('dish', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
            'description' => 'varchar(255) NOT NULL',
            'kkal' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        $this->dropTable('dish');
    }
}
