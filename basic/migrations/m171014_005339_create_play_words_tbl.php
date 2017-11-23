<?php

use yii\db\Migration;

class m171014_005339_create_play_words_tbl extends Migration
{
    public function safeUp()
    {
        $this->createTable('play_words', [
            'id' => $this->primaryKey(),
            'word' =>  'VARCHAR(255) NOT NULL',
            'used' =>  'INT(1) NOT NULL DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function safeDown()
    {
        echo "m171014_005339_create_play_words_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171014_005339_create_play_words_tbl cannot be reverted.\n";

        return false;
    }
    */
}
