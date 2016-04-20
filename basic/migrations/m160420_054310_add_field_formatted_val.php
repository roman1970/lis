<?php

use yii\db\Migration;

class m160420_054310_add_field_formatted_val extends Migration
{
    public function up()
    {

        $this->addColumn('{{curr_history}}', 'formatted_val', 'VARCHAR(255) NOT NULL');

    }

    public function down()
    {
        echo "m160420_054310_add_field_formatted_val cannot be reverted.\n";

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
