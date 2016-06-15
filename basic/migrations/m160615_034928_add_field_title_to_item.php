<?php

use yii\db\Migration;

class m160615_034928_add_field_title_to_item extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'title', 'VARCHAR(255) DEFAULT NULL');
    }

    public function down()
    {
    }
}
