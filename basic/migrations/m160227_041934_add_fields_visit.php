<?php

use yii\db\Migration;

class m160227_041934_add_fields_visit extends Migration
{
    public function up()
    {
        $this->addColumn('{{visit}}', 'refer', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{visit}}', 'browser', 'VARCHAR(255) NOT NULL');

    }

    public function down()
    {
        echo "m160227_041934_add_fields_visit cannot be reverted.\n";

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
