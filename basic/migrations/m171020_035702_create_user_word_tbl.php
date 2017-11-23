<?php

use yii\db\Migration;

class m171020_035702_create_user_word_tbl extends Migration
{
    public function safeUp()
    {
        $this->createTable('pw_user', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'pwd' => 'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createTable('user_word', [
            'id' => $this->primaryKey(),
            'user_id' => 'INT(4) NOT NULL',
            'word_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_user_word_user_id", 'user_word', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{user_word}} ADD FOREIGN KEY (`user_id`) REFERENCES {{pw_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

        $this->createIndex("ux_user_word_word_id", 'user_word', "word_id", false);
        $this->db->createCommand('ALTER TABLE {{user_word}} ADD FOREIGN KEY (`word_id`) REFERENCES {{play_words}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function safeDown()
    {
        echo "m171020_035702_create_user_word_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171020_035702_create_user_word_tbl cannot be reverted.\n";

        return false;
    }
    */
}
