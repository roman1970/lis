<?php

use yii\db\Migration;

class m170203_095646_create_football_news extends Migration
{
    public function up()
    {
        $this->createTable('football_news', [
            'id' => $this->primaryKey(),
            'title' =>  'VARCHAR(255) NOT NULL',
            'description' => 'TEXT NOT NULL',
            'guid' => 'INT(12) NOT NULL',
            'link' =>  'VARCHAR(255) NOT NULL',
            'pdalink' =>  'VARCHAR(255) NOT NULL',
            'author' =>  'VARCHAR(255) NOT NULL',
            'sections' =>  'VARCHAR(255) NOT NULL',
            'tags' =>  'VARCHAR(255) NOT NULL',
            'pud_date' =>  'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        echo "m170203_095646_create_football_news cannot be reverted.\n";

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
