<?php

use yii\db\Migration;

class m160810_022142_add_fields_to_controll_acts extends Migration
{
    public function up()
    {
        $this->addColumn('{{controll_acts}}', 'user_id', 'INT(2)  DEFAULT 8');
        $this->addColumn('{{controll_acts}}', 'mark', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{controll_acts}}', 'mark_status', 'INT(4)  DEFAULT 0');

        $this->createIndex("ux_controll_acts_user_id", 'controll_acts', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{controll_acts}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
