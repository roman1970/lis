<?php

use yii\db\Migration;

class m160902_030310_add_text_to_author extends Migration
{
    public function up()
    {
        $this->addColumn('{{authors}}', 'description', 'TEXT NOT NULL');
    }

    public function down()
    {
    }
}
