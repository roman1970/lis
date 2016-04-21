<?php

use yii\db\Migration;

class m160421_043246_add_currency_field_to_products extends Migration
{
    public function up()
    {
        $this->addColumn('{{products}}', 'currency', 'VARCHAR(8) DEFAULT 0');
    }

    public function down()
    {
    }
}
