<?php

use yii\db\Migration;

class m160727_031956_add_index_to_items extends Migration
{
    public function up()
    {

        $this->createIndex("ux_items_play_status", 'items', "play_status", false);
        $this->db->createCommand('ALTER TABLE {{items}} ADD FOREIGN KEY (`play_status`) REFERENCES  {{playlists}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
