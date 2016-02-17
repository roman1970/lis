<?php

use yii\db\Migration;

class m160217_041431_add_fields_more_matches extends Migration
{
    public function up()
    {
        $this->addColumn('{{chl_matches}}', 'date', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{chl_matches}}', 'time_beg', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{chl_matches}}', 'judges', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{chl_matches}}', 'audience', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'stadium', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{chl_matches}}', 'player_off', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{chl_matches}}', 'gk_substitution', 'VARCHAR(255) NOT NULL');
        $this->addColumn('{{chl_matches}}', 'errors', 'TEXT NOT NULL');

    }

    public function down()
    {
        echo "m160217_041431_add_fields_more_matches cannot be reverted.\n";

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
