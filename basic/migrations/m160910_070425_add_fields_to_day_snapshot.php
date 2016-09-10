<?php

use yii\db\Migration;

class m160910_070425_add_fields_to_day_snapshot extends Migration
{
    public function up()
    {
        $this->addColumn('{{day_snapshot}}', 'oil_brend', 'DECIMAL(10,2) DEFAULT 0');
        $this->addColumn('{{day_snapshot}}', 'spent', 'DECIMAL(10,2) DEFAULT 0');
    }

    public function down()
    {
    }
}
