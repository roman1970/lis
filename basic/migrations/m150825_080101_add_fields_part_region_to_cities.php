<?php

use yii\db\Schema;
use yii\db\Migration;

class m150825_080101_add_fields_part_region_to_cities extends Migration
{
    public function up()
    {
        $this->addColumn('{{cities}}', 'part', 'varchar(255) NOT NULL');
        $this->addColumn('{{cities}}', 'region', 'varchar(255) NOT NULL');

    }

    public function down()
    {
        echo "m150825_080101_add_fields_part_region_to_cities cannot be reverted.\n";

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
