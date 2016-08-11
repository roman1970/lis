<?php

use yii\db\Migration;

class m160811_023553_create_tasked extends Migration
{
    public function up()
    {

        $this->createTable('tasked', [
            'id' => $this->primaryKey(),
            'task_id' => 'INT(4) NOT NULL',
            'act_id' => 'INT(8) NOT NULL',
            'user_id' => 'INT(4) DEFAULT 8',
            'mark' => 'INT(4) DEFAULT 0',
            'mark_status' => 'INT(4) DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );


        $this->createIndex("ux_tasked_task_id", 'tasked', "task_id", false);
        $this->db->createCommand('ALTER TABLE {{tasked}} ADD FOREIGN KEY (`task_id`) REFERENCES {{task}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_tasked_act_id", 'tasked', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{tasked}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_tasked_user_id", 'tasked', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{tasked}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('tasked');
    }
}
