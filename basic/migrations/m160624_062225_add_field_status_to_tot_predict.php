<?php

use yii\db\Migration;

class m160624_062225_add_field_status_to_tot_predict extends Migration
{
    public function up()
    {
        $this->addColumn('{{tot_predict}}', 'status', 'INT(1) DEFAULT 0');
    }

    public function down()
    {
    }
}
