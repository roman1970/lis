<?php

use yii\db\Migration;

class m160216_034430_add_fields_khl_matches extends Migration
{
    public function up()
    {
        $this->addColumn('{{chl_matches}}', 'shot_in_goals_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'shot_in_goals_guest', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'shot_reflected_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'shot_reflected_guest', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'removal_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'removal_guest', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'penalty_time_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'penalty_time_guest', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'goals_in_more_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'goals_in_more_guest', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'force_dodge_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'force_dodge_guest', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'facedown_vic_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'facedown_vic_guest', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'goals_in_less_host', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'goals_in_less_guest', 'INT(4) DEFAULT 0');

    }

    public function down()
    {
        echo "m160216_034430_add_fields_khl_matches cannot be reverted.\n";

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
