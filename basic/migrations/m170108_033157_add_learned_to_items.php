<?php

use yii\db\Migration;

class m170108_033157_add_learned_to_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'learned', 'INT(1)  DEFAULT 0');

    }

    public function down()
    {
        echo "m170108_033157_add_learned_to_items cannot be reverted.\n";

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
