<?php

use yii\db\Migration;

class m160727_024807_add_field_plstatus_to_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'play_status', 'INT(4)  DEFAULT 0');
    }

    public function down()
    {
    }
}
