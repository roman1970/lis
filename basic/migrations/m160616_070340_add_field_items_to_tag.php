<?php

use yii\db\Migration;

class m160616_070340_add_field_items_to_tag extends Migration
{
    public function up()
    {
        $this->addColumn('{{tag}}', 'items', 'VARCHAR(255) DEFAULT NULL');
    }

    public function down()
    {
    }
}
