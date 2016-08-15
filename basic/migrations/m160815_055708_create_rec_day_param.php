<?php

use yii\db\Migration;

class m160815_055708_create_rec_day_param extends Migration
{
    public function up()
    {
        $this->createTable('rec_day_param', [
            'id' => $this->primaryKey(),
            'day_param_id' => 'INT(4) NOT NULL',
            'act_id' => 'INT(8) NOT NULL',
            'user_id' => 'INT(8) NOT NULL',
            'value' => 'DECIMAL(10,4) DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_rec_day_param_day_param_id", 'rec_day_param', "day_param_id", false);
        $this->db->createCommand('ALTER TABLE {{rec_day_param}} ADD FOREIGN KEY (`day_param_id`) REFERENCES {{day_params}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_rec_day_param_act_id", 'rec_day_param', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{rec_day_param}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_rec_day_param_user_id", 'rec_day_param', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{rec_day_param}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('rec_day_param');
    }
}
