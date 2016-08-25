<?php

use yii\db\Migration;

class m160825_085008_create_events extends Migration
{
    public function up()
    {
        $this->createTable('events', [
            'id' => $this->primaryKey(),
            'text' => 'TEXT',
            'act_id' => 'INT(8) NOT NULL',
            'user_id' => 'INT(8) NOT NULL',
            'cat_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_events_cat_id", 'events', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{events}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_events_act_id", 'events', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{events}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_events_user_id", 'events', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{events}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

        $this->addColumn('{{sources}}', 'is_next', 'INT(2)  DEFAULT 0');

    }

    public function down()
    {
        $this->dropTable('events');
    }
}
