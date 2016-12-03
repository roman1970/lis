<?php

use yii\db\Migration;

class m161203_010915_add_fields_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'published', 'INT(2) DEFAULT 1');
        $this->addColumn('{{items}}', 'parent_item_id', 'INT(10) DEFAULT 0');

    }

    public function down()
    {
        echo "m161203_010915_add_fields_items cannot be reverted.\n";

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
