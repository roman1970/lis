<?php

use yii\db\Migration;

class m161204_032723_add_link_song_texts extends Migration
{
    public function up()
    {
        $this->addColumn('{{song_texts}}', 'link', 'VARCHAR(255)  DEFAULT NULL');
    }

    public function down()
    {
        echo "m161204_032723_add_link_song_texts cannot be reverted.\n";

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
