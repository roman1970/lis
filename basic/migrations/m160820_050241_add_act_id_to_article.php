<?php

use yii\db\Migration;

class m160820_050241_add_act_id_to_article extends Migration
{
    public function up()
    {

        $this->addColumn('{{qparticles}}', 'act_id', 'INT(4)  DEFAULT 1');

        $this->createIndex("ux_qparticles_act_id", 'qparticles', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{qparticles}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
