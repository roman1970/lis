<?php

use yii\db\Migration;

class m160712_084647_add_field_radio_que_to_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'radio_que', 'INT(4)  DEFAULT 0');
    }

    public function down()
    {
    }
}
