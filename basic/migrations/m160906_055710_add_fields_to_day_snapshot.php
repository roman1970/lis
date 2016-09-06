<?php

use yii\db\Migration;

class m160906_055710_add_fields_to_day_snapshot extends Migration
{
    public function up()
    {
        $this->addColumn('{{day_snapshot}}', 'kkal', 'INT(8) DEFAULT 0');
        $this->addColumn('{{day_snapshot}}', 'useful_bal', 'INT(8) DEFAULT 0');
        $this->addColumn('{{day_snapshot}}', 'sun_set', 'VARCHAR(24) NOT NULL');
        $this->addColumn('{{day_snapshot}}', 'sun_rise', 'VARCHAR(24) NOT NULL');
        $this->addColumn('{{day_snapshot}}', 'moon_old', 'INT(8) DEFAULT 0');

    }

    public function down()
    {
    }
}
