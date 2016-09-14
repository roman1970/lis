<?php

use yii\db\Migration;

class m160914_070338_add_field_old_data_event extends Migration
{
    public function up()
    {
        $this->addColumn('{{events}}', 'old_data', 'VARCHAR(24)  DEFAULT 0');

    }

    public function down()
    {
        echo "m160914_070338_add_field_old_data_event cannot be reverted.\n";

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
