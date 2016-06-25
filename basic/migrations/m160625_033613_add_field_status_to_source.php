<?php

use yii\db\Migration;

class m160625_033613_add_field_status_to_source extends Migration
{
    public function up()
    {
        $this->addColumn('{{sources}}', 'status', 'INT(2)  DEFAULT 0');
    }

    public function down()
    {
    }
}
