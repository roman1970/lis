<?php

use yii\db\Migration;

class m170306_030317_create_table_play_lst extends Migration
{
    public function up()
    {
        $this->createTable('play_lst_bind', [
            'id' => $this->primaryKey(),
            'item_id' => 'INT(4) NOT NULL',
            'play_list_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_play_lst_bind_item_id", 'play_lst_bind', "item_id", false);
        $this->db->createCommand('ALTER TABLE {{play_lst_bind}} ADD FOREIGN KEY (`item_id`) REFERENCES {{items}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_play_lst_bind_play_list_id", 'play_lst_bind', "play_list_id", false);
        $this->db->createCommand('ALTER TABLE {{play_lst_bind}} ADD FOREIGN KEY (`play_list_id`) REFERENCES {{playlists}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        echo "m170306_030317_create_table_play_lst cannot be reverted.\n";

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
