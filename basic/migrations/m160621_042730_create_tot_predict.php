<?php

use yii\db\Migration;

class m160621_042730_create_tot_predict extends Migration
{
    public function up()
    {

        $this->createTable('tot_predict', [
            'id' => $this->primaryKey(),
            'user_id' => 'INT(8) NOT NULL',
            'date' => 'DATETIME DEFAULT NULL',
            'host_g' => 'INT(4) NOT NULL',
            'guest_g' => 'INT(4) NOT NULL',
            'match_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_tot_predict_user_id", 'tot_predict', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{tot_predict}} ADD FOREIGN KEY (`user_id`) REFERENCES  {{tot_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_tot_predict_match_id", 'tot_predict', "match_id", false);
        $this->db->createCommand('ALTER TABLE {{tot_predict}} ADD FOREIGN KEY (`match_id`) REFERENCES  {{tot_match}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('tot_predict');
    }
}
