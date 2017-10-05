<?php

use yii\db\Migration;

class m170822_010832_create_tbl_deutsch_tournament extends Migration
{
    public function safeUp()
    {
        $this->createTable('deutsch_tournament', [
            'id' => $this->primaryKey(),
            'user_id' =>  'INT(8) NOT NULL',
            'mark' =>  'VARCHAR(255) NOT NULL',
            'time' => 'INT(12) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_deutsch_tournament_user_id", 'deutsch_tournament', "user_id", false);
        
        $this->db->createCommand('ALTER TABLE {{deutsch_tournament}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function safeDown()
    {
        echo "m170822_010832_create_tbl_deutsch_tournament cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170822_010832_create_tbl_deutsch_tournament cannot be reverted.\n";

        return false;
    }
    */
}
