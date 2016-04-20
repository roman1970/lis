<?php

use yii\db\Migration;

class m160420_060939_add_field_formatted_val_to_products extends Migration
{
    public function up()
    {
        $this->addColumn('{{products}}', 'formatted_val', 'VARCHAR(255) NOT NULL');
    }

    public function down()
    {
    }
}
