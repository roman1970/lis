<?php

use yii\db\Migration;

class m160209_100232_add_fields_chl_players_tbl extends Migration
{
    public function up()
    {
        $this->addColumn('{{chl_players}}', 'number', 'INT(1) DEFAULT 0');
        $this->addColumn('{{chl_players}}', 'country_id', 'INT(2) NOT NULL');
        $this->addColumn('{{chl_players}}', 'goals', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_players}}', 'assist', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_players}}', 'game', 'INT(4) DEFAULT 0');

    }

    public function down()
    {
        echo "m160209_100232_add_fields_chl_players_tbl cannot be reverted.\n";

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
