<?php

use yii\db\Migration;

class m160323_035607_create_mark_it extends Migration
{
    public function up()
    {
        $this->createTable('mark_it', [
            'id' => $this->primaryKey(),
            'date' => 'DATETIME DEFAULT NULL',
            'ball' => "enum('0','1','2','3','4','5') DEFAULT '0'",
            'user_id' => 'INT(8) NOT NULL',
            'action_id' => 'INT(8) NOT NULL',
        ]);

        $this->createIndex("ux_mark_it_user_id", 'mark_it', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{mark_it}} ADD FOREIGN KEY (`user_id`) REFERENCES  {{user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_mark_it_action_id", 'mark_it', "action_id", false);
        $this->db->createCommand('ALTER TABLE {{mark_it}} ADD FOREIGN KEY (`action_id`) REFERENCES  {{mark_actions}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('mark_it');
    }
}
