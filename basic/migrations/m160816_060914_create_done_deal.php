<?php

use yii\db\Migration;

class m160816_060914_create_done_deal extends Migration
{
    public function up()
    {
        $this->createTable('done_deal', [
            'id' => $this->primaryKey(),
            'deal_id' => 'INT(4) NOT NULL',
            'act_id' => 'INT(8) NOT NULL',
            'user_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_done_deal_day_param_id", 'done_deal', "deal_id", false);
        $this->db->createCommand('ALTER TABLE {{done_deal}} ADD FOREIGN KEY (`deal_id`) REFERENCES {{deals}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_done_deal_act_id", 'done_deal', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{done_deal}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_done_deal_user_id", 'done_deal', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{done_deal}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('done_deal');
    }
}
