<?php

use yii\db\Migration;

class m170901_042604_alter_field_phrade_gen_id_items extends Migration
{
    public function safeUp()
    {
       // $this->db->createCommand("ALTER TABLE {{items}} MODIFY COLUMN {{phrase_gen_id}} VARCHAR(255) DEFAULT NULL")->execute();

    }

    public function safeDown()
    {
        echo "m170901_042604_alter_field_phrade_gen_id_items cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170901_042604_alter_field_phrade_gen_id_items cannot be reverted.\n";

        return false;
    }
    */
}
