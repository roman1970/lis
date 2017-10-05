<?php

use yii\db\Migration;

class m170816_013814_add_field_humor_to_song_texts extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{song_texts}}', 'humor', 'INT(1) DEFAULT 0');
    }

    public function safeDown()
    {
        echo "m170816_013814_add_field_humor_to_song_texts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170816_013814_add_field_humor_to_song_texts cannot be reverted.\n";

        return false;
    }
    */
}
