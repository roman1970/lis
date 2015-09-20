<?php

use yii\db\Schema;
use yii\db\Migration;

class m150920_064750_add_field_tree_to_categories extends Migration
{
    public function up()
    {
        $this->addColumn('{{qpcategory}}', 'tree', 'INT(4) NOT NULL');

    }

    public function down()
    {
        echo "m150920_064750_add_field_tree_to_categories cannot be reverted.\n";

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
