<?php

use yii\db\Migration;

class m161203_104339_create_song_texts extends Migration
{
    public function up()
    {
        $this->createTable('song_texts', [
            'id' => $this->primaryKey(),
            'source_id' => 'INT(11) NOT NULL',
            'title' =>  'VARCHAR(255) NOT NULL',
            'text' => 'TEXT NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_song_texts_source_id", 'song_texts', "source_id", false);
        $this->db->createCommand('ALTER TABLE {{song_texts}} ADD FOREIGN KEY (`source_id`) REFERENCES  {{sources}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m161203_104339_create_song_texts cannot be reverted.\n";

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
