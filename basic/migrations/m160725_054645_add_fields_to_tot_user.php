<?php

use yii\db\Migration;

class m160725_054645_add_fields_to_tot_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{tot_user}}', 'balance', 'DECIMAL(10,4)  DEFAULT 0');
        $this->addColumn('{{tot_user}}', 'precise', 'INT(4)  DEFAULT 0');
        $this->addColumn('{{tot_user}}', 'result', 'INT(4)  DEFAULT 0');
        $this->addColumn('{{tot_user}}', 'no_goal', 'INT(4)  DEFAULT 0');
        
    }

    public function down()
    {
    }
}
