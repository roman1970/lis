<?php

use yii\db\Migration;

class m170804_010821_deutsch_item_del_columns extends Migration
{
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE {{deutsch_item}} DROP COLUMN {{e_word}}")->execute();
        $this->db->createCommand("ALTER TABLE {{deutsch_item}} DROP COLUMN {{e_phrase}}")->execute();
        $this->db->createCommand("ALTER TABLE {{deutsch_item}} DROP COLUMN {{e_word_translation}}")->execute();
        $this->db->createCommand("ALTER TABLE {{deutsch_item}} DROP COLUMN {{e_phrase_translation}}")->execute();
        $this->db->createCommand("ALTER TABLE {{deutsch_item}} DROP COLUMN {{e_word_transcription}}")->execute();
        $this->db->createCommand("ALTER TABLE {{deutsch_item}} DROP COLUMN {{e_phrase_transcription}}")->execute();

    }

    public function safeDown()
    {
        echo "m170804_010821_deutsch_item_del_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170804_010821_deutsch_item_del_columns cannot be reverted.\n";

        return false;
    }
    */
}
