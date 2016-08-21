<?php

use yii\db\Migration;

class m160821_073805_add_act_id_to_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'act_id', 'INT(4)  DEFAULT 1');

        $this->createIndex("ux_items_act_id", 'items', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{items}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
