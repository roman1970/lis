<?php

use yii\db\Migration;

class m160819_032015_add_field_is_next_to_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'is_next', 'INT(1)  DEFAULT 0');
    }

    public function down()
    {
    }
}
