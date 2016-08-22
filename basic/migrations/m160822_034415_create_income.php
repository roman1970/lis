<?php

use yii\db\Migration;

class m160822_034415_create_income extends Migration
{
    public function up()
    {
        $this->createTable('income', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
            'description' => 'TEXT DEFAULT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
    }

    public function down()
    {
        $this->dropTable('income');
    }
}
