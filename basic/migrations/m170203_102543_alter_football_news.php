<?php

use yii\db\Migration;

class m170203_102543_alter_football_news extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE {{football_news}} MODIFY COLUMN {{guid}} VARCHAR(255) DEFAULT NULL")->execute();
      //  $this->db->createCommand("ALTER TABLE {{curr_history}} MODIFY COLUMN {{value}} DECIMAL(10,4)  DEFAULT 0")->execute();

    }

    public function down()
    {
        echo "m170203_102543_alter_football_news cannot be reverted.\n";

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
