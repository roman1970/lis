<?php

use yii\db\Migration;

class m161215_104051_create_pogodaxxi extends Migration
{
    public function up()
    {
        $this->createTable('pogodaxxi', [
            'id' => $this->primaryKey(),
            'title' =>  'VARCHAR(255) NOT NULL',
            'year' => 'INT(6) NOT NULL',
            'date' =>  'INT(6) NOT NULL',
            'month' => 'INT(6) NOT NULL',
            'week' =>  'INT(6) NOT NULL',
            'day_week' =>  'INT(6) NOT NULL',
            'prim' => 'TEXT NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        echo "m161215_104051_create_pogodaxxi cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
