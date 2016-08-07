<?php

use yii\db\Migration;

class m160807_031827_create_act_model extends Migration
{
    public function up()
    {
        
        $this->createTable('act_model', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
        ]);

        $this->createIndex("ux_ate_dish_id", 'ate', "dish_id", false);
        $this->db->createCommand('ALTER TABLE {{ate}} ADD FOREIGN KEY (`dish_id`) REFERENCES {{dish}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_ate_act_id", 'ate', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{ate}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_controll_acts_model_id", 'controll_acts', "model_id", false);
        $this->db->createCommand('ALTER TABLE {{controll_acts}} ADD FOREIGN KEY (`model_id`) REFERENCES {{act_model}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('act_model');
    }
}
