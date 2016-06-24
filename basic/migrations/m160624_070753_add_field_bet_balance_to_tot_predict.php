<?php

use yii\db\Migration;

class m160624_070753_add_field_bet_balance_to_tot_predict extends Migration
{
    public function up()
    {
        $this->addColumn('{{tot_predict}}', 'bet_balance', 'DECIMAL(10,4)  DEFAULT 0');
    }

    public function down()
    {
    }
}
