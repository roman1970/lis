<?php

use yii\db\Migration;

class m160325_060825_add_field_pseudo_to_mark_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{mark_user}}', 'pseudo', 'VARCHAR(255) NOT NULL');
    }

    public function down()
    {
    }
}
