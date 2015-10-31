<?php

use yii\db\Schema;
use yii\db\Migration;

class m151026_040012_create_table_authors extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{authors}}', array(
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        echo "m151026_040012_create_table_authors cannot be reverted.\n";

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
