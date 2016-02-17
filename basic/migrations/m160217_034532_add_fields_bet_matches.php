<?php

use yii\db\Migration;

class m160217_034532_add_fields_bet_matches extends Migration
{
    public function up()
    {
        $this->addColumn('{{chl_matches}}', 'bet_vic_host', 'FLOAT(4,2) DEFAULT NULL');
        $this->addColumn('{{chl_matches}}', 'bet_nobody', 'FLOAT(4,2) DEFAULT NULL');
        $this->addColumn('{{chl_matches}}', 'bet_vic_guest', 'FLOAT(4,2) DEFAULT NULL');

    }

    public function down()
    {
        echo "m160217_034532_add_fields_bet_matches cannot be reverted.\n";

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
