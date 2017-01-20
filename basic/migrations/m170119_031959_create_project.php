<?php

use yii\db\Migration;

class m170119_031959_create_project extends Migration
{
    public function up()
    {
        $this->createTable('idea', [
            'id' => $this->primaryKey(),
            'items' =>  'VARCHAR(255) NOT NULL',
            'text' => 'TEXT NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        echo "m170119_031959_create_project cannot be reverted.\n";

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
