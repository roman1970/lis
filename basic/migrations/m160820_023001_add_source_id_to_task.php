<?php

use yii\db\Migration;

class m160820_023001_add_source_id_to_task extends Migration
{
    public function up()
    {
        $this->addColumn('{{task}}', 'source_id', 'INT(4)  DEFAULT 327');

        $this->createIndex("ux_task_source_id", 'task', "source_id", false);
        $this->db->createCommand('ALTER TABLE {{task}} ADD FOREIGN KEY (`source_id`) REFERENCES {{sources}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
