<?php

use yii\db\Migration;

class m160712_014321_add_field_relises_to_authors extends Migration
{
    public function up()
    {
        $this->addColumn('{{authors}}', 'releases', 'INT(4)  DEFAULT 0');
    }

    public function down()
    {
    }
}
