<?php

use yii\db\Migration;

class m170803_100135_deutsch_item extends Migration
{
    public function safeUp()
    {
        $this->createTable('deutsch_item', [
            'id' => $this->primaryKey(),
            'd_word' =>  'VARCHAR(255) NOT NULL',
            'e_word' =>  'VARCHAR(255) NOT NULL',
            'd_phrase' =>  'VARCHAR(255) NOT NULL',
            'e_phrase' =>  'VARCHAR(255) NOT NULL',
            'd_word_translation' =>  'VARCHAR(255) NOT NULL',
            'e_word_translation' =>  'VARCHAR(255) NOT NULL',
            'd_phrase_translation' =>  'VARCHAR(255) NOT NULL',
            'e_phrase_translation' =>  'VARCHAR(255) NOT NULL',
            'd_word_transcription' =>  'VARCHAR(255) NOT NULL',
            'e_word_transcription' =>  'VARCHAR(255) NOT NULL',
            'd_phrase_transcription' =>  'VARCHAR(255) NOT NULL',
            'e_phrase_transcription' =>  'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function safeDown()
    {
        echo "m170803_100135_deutsch_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_100135_deutsch_item cannot be reverted.\n";

        return false;
    }
    */
}
