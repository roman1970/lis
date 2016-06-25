<?php

use yii\db\Migration;

class m160625_041523_add_field_status_to_author extends Migration
{
    public function up()
    {
        $this->addColumn('{{authors}}', 'status', 'INT(2)  DEFAULT 0');
    }

    public function down()
    {
    }
}
