<?php

use yii\db\Schema;
use yii\db\Migration;

class m150810_033000_create_table_weather extends Migration
{
    public function up()
    {
	$this->createTable(
            '{{weather}}', array(
                'id' => 'pk',
                'name' => 'varchar(255) NOT NULL',
                'weather_link' => 'varchar(255) NOT NULL',
                'country_id' => 'INT(11) NOT NULL',
            ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        echo "m150810_033000_create_table_weather cannot be reverted.\n";

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
