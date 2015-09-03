<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_080637_add_field_yndid_to_city extends Migration
{
    public function up()
    {
        $this->addColumn('{{cities}}', 'yndid', 'varchar(255) NOT NULL');

    }

    public function down()
    {
        echo "m150825_080637_add_field_yndid_to_city cannot be reverted.\n";

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
