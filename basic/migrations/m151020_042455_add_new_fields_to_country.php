<?php

use yii\db\Schema;
use yii\db\Migration;

class m151020_042455_add_new_fields_to_country extends Migration
{
    public function up()
    {
        $this->addColumn('{{country}}', 'icon', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{country}}', 'iso_code', 'VARCHAR(24) NOT NULL');
        $this->addColumn('{{country}}', 'soc_abrev', 'VARCHAR(24) NOT NULL');
        $this->addColumn('{{country}}', 'soccer_code', 'INT(4) DEFAULT 0');

    }

    public function down()
    {
        echo "m151020_042455_add_new_fields_to_country cannot be reverted.\n";

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
