<?php

use yii\db\Migration;

class m160429_094511_add_field_mark_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{mark_user}}', 'money', 'DECIMAL(10,4)  DEFAULT 0');

    }

    public function down()
    {
        echo "m160429_094511_add_field_mark_user cannot be reverted.\n";

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
