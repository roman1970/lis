<?php

use yii\db\Migration;

class m160110_100304_create_testing_table extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{testing}}', array(
                'id' => 'pk',
                'question' => 'varchar(255) NOT NULL',
                'answer' => 'text',
                'right' => 'int(2) DEFAULT 0',
                'img' => 'varchar(255) NOT NULL'
            ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        echo "m160110_100304_create_testing_table cannot be reverted.\n";

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
