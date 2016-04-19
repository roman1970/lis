<?php

use yii\db\Migration;

class m160419_065934_alter_curr_his_tbl extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE {{curr_history}} MODIFY COLUMN {{date}} DATE  DEFAULT NULL")->execute();
        $this->db->createCommand("ALTER TABLE {{curr_history}} MODIFY COLUMN {{value}} DECIMAL(10,4)  DEFAULT 0")->execute();

    }

    public function down()
    {
        echo "m160419_065934_alter_curr_his_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
