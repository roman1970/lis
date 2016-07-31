<?php

use yii\db\Migration;

class m160731_065900_add_field_to_items extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'in_work_prim', 'VARCHAR(255) NOT NULL');
    }

    public function down()
    {
    }
}
