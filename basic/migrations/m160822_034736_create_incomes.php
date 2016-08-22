<?php

use yii\db\Migration;

class m160822_034736_create_incomes extends Migration
{
    public function up()
    {
        $this->createTable('incomes', [
            'id' => $this->primaryKey(),
            'income_id' => 'INT(4) NOT NULL',
            'act_id' => 'INT(8) NOT NULL',
            'user_id' => 'INT(8) NOT NULL',
            'money' => 'DECIMAL(10,4) DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_incomes_income_id", 'incomes', "income_id", false);
        $this->db->createCommand('ALTER TABLE {{incomes}} ADD FOREIGN KEY (`income_id`) REFERENCES {{income}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_incomes_act_id", 'incomes', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{incomes}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_incomes_user_id", 'incomes', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{incomes}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('incomes');
    }
}
