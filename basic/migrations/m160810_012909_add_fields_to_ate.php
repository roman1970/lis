<?php

use yii\db\Migration;

class m160810_012909_add_fields_to_ate extends Migration
{
    public function up()
    {
        $this->addColumn('{{ate}}', 'user_id', 'INT(2)  DEFAULT 8');
        $this->addColumn('{{ate}}', 'mark', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{ate}}', 'mark_status', 'INT(4)  DEFAULT 0');

        $this->createIndex("ux_ate_user_id", 'ate', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{ate}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
