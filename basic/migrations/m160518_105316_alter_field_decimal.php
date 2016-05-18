<?php

use yii\db\Migration;

class m160518_105316_alter_field_decimal extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE {{weathernew}} MODIFY COLUMN {{temp}} DECIMAL(10,4)  DEFAULT 0")->execute();
        $this->db->createCommand("ALTER TABLE {{weathernew}} MODIFY COLUMN {{temp_min}} DECIMAL(10,4)  DEFAULT 0")->execute();
        $this->db->createCommand("ALTER TABLE {{weathernew}} MODIFY COLUMN {{temp_max}} DECIMAL(10,4)  DEFAULT 0")->execute();

    }

    public function down()
    {
        echo "m160518_105316_alter_field_decimal cannot be reverted.\n";

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
