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
        'chas' => 'INT(4) NOT NULL',
        'date' => 'DATETIME',
        'atmdavlnaurst' => 'INT(8) NOT NULL',
        'temp' => 'FLOAT(8) NOT NULL',
        'otnvlaz' => 'INT(8) NOT NULL',
        'naprvetra' => 'varchar(8) NOT NULL',
        'scorvetra' => 'INT(8) NOT NULL',
        'balobl' => 'INT(8) NOT NULL',
        'gorvid' => 'INT(8) NOT NULL',
        'osad24' => 'FLOAT(8) NOT NULL',
        'osad12' => 'FLOAT(8) NOT NULL',
        'vyspok' => 'INT(8) NOT NULL',
        'dd' => 'INT(8) NOT NULL',
        'country_id' => 'INT(2) NOT NULL'
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
