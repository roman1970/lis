<?php

use yii\db\Migration;

class m160917_031309_add_act_id_to_test_klavaro extends Migration
{
    public function up()
    {
        $this->addColumn('{{test_klavaro}}', 'act_id', 'INT(2)  DEFAULT 0');

        $this->createIndex("ux_test_klavaro_act_id", 'test_klavaro', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{test_klavaro}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
