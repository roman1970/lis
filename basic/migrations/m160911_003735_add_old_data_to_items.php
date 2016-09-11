<?php

use yii\db\Migration;

class m160911_003735_add_old_data_to_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'old_data', 'VARCHAR(24)  DEFAULT 0');
    }

    public function down()
    {
    }
}
