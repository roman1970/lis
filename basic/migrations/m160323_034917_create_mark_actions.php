<?php

use yii\db\Migration;

class m160323_034917_create_mark_actions extends Migration
{
    public function up()
    {
        $this->createTable('mark_actions', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'group_id' => 'INT(8) NOT NULL',
        ]);

        $this->createIndex("ux_mark_actions_group_id", 'mark_actions', "group_id", false);
        $this->db->createCommand('ALTER TABLE {{mark_actions}} ADD FOREIGN KEY (`group_id`) REFERENCES  {{mark_group}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('mark_actions');
    }
}
