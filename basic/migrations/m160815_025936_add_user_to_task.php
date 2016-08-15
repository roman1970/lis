<?php

use yii\db\Migration;

class m160815_025936_add_user_to_task extends Migration
{
    public function up()
    {
        $this->addColumn('{{task}}', 'user_id', 'INT(4)  DEFAULT 8');

        $this->createIndex("ux_task_user_id", 'task', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{task}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
