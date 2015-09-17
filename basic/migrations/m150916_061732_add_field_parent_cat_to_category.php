<?php

use yii\db\Schema;
use yii\db\Migration;

class m150916_061732_add_field_parent_cat_to_category extends Migration
{
    public function up()
    {
        $this->addColumn('{{qpcategory}}', 'parent_cat', 'INT(2) NOT NULL');

    }

    public function down()
    {
        echo "m150916_061732_add_field_parent_cat_to_category cannot be reverted.\n";

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
