<?php

use yii\db\Migration;

class m160226_111251_create_visit_table extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{visit}}', array(
                'id' => 'pk',
                'time' => 'DATETIME',
                'ip' => 'VARCHAR(255) DEFAULT NULL',

            ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
    }

    public function down()
    {
        echo "m160226_111251_create_visit_table cannot be reverted.\n";

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
