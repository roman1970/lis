<?php

use yii\db\Migration;

class m170312_005307_add_unic_key_to_tournament extends Migration
{
    public function up()
    {
        $this->createIndex("ux_foo_tournament_name", 'foo_tournament', "name", false);
        $this->db->createCommand('ALTER TABLE {{foo_tournament}} ADD UNIQUE INDEX `ux_name` (name);')->execute();
        
    }

    public function down()
    {
        echo "m170312_005307_add_unic_key_to_tournament cannot be reverted.\n";

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
