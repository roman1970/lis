<?php

use yii\db\Migration;

class m170119_062129_add_field_title_to_idea extends Migration
{
    public function up()
    {
        $this->addColumn('{{idea}}', 'title', 'VARCHAR(255)  DEFAULT NULL');

    }

    public function down()
    {
        echo "m170119_062129_add_field_title_to_idea cannot be reverted.\n";

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
