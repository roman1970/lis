<?php

use yii\db\Migration;

class m151104_071442_create_new_table_diarticles extends Migration
{
    public function up()
    {
        /*$this->createTable(
            '{{diarticles}}', array(
            'id' => 'pk',
            'title' => 'VARCHAR(225)',
            'text' => 'TEXT NOT NULL',
            'd_created' => 'DATETIME',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
        */
    }

    public function down()
    {
        echo "m151104_071442_create_new_table_diarticles cannot be reverted.\n";

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
