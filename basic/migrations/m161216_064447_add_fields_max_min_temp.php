<?php

use yii\db\Migration;

class m161216_064447_add_fields_max_min_temp extends Migration
{
    public function up()
    {
        $this->addColumn('{{pogodaxxi}}', 'max_temp', 'INT(10) DEFAULT 0');
        $this->addColumn('{{pogodaxxi}}', 'min_temp', 'INT(10) DEFAULT 0');

    }

    public function down()
    {
        echo "m161216_064447_add_fields_max_min_temp cannot be reverted.\n";

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
