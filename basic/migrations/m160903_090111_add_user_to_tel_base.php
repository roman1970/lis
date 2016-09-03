<?php

use yii\db\Migration;

class m160903_090111_add_user_to_tel_base extends Migration
{
    public function up()
    {
        $this->addColumn('{{telbase}}', 'user_id', 'INT(2) DEFAULT 8');

        $this->createIndex("ux_telbase_user_id", 'telbase', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{telbase}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
