<?php

use yii\db\Migration;

class m160218_062300_add_fields_events_tbl extends Migration
{
    public function up()
    {
        $this->addColumn('{{chl_events}}', 'is_host', 'INT(1) DEFAULT 0');
        $this->addColumn('{{chl_events}}', 'prim', 'TEXT NOT NULL');
        $this->addColumn('{{chl_events}}', 'assist', 'VARCHAR(255) NOT NULL');

    }

    public function down()
    {
        echo "m160218_062300_add_fields_events_tbl cannot be reverted.\n";

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
