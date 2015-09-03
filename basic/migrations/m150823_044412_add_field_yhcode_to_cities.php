<?php

use yii\db\Schema;
use yii\db\Migration;

class m150823_044412_add_field_yhcode_to_cities extends Migration
{
    public function up()
    {
        $this->addColumn('{{cities}}', 'yhcode', 'varchar(255) NOT NULL');

    }

    public function down()
    {
        echo "m150823_044412_add_field_yhcode_to_cities cannot be reverted.\n";

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
