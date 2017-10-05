<?php

use yii\db\Migration;

class m170602_060500_add_field_original_audio_items extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{items}}', 'original_song_id', 'INT(10) DEFAULT NULL');

        $this->createIndex("ux_items_original_song_id", 'items', "original_song_id", false);
        $this->db->createCommand('ALTER TABLE {{items}} ADD FOREIGN KEY (`original_song_id`) REFERENCES {{song_texts}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();
        
    }

    public function safeDown()
    {
        echo "m170602_060500_add_field_original_audio_items cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170602_060500_add_field_original_audio_items cannot be reverted.\n";

        return false;
    }
    */
}
