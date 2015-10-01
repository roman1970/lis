<?php

use yii\db\Schema;
use yii\db\Migration;

class m150930_120752_add_field_action_to_category extends Migration
{
    public function up()
    {
        $this->addColumn('{{qpcategory}}', 'action', 'VARCHAR(255) DEFAULT NULL');

    }

    public function down()
    {
        echo "m150930_120752_add_field_action_to_category cannot be reverted.\n";

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
