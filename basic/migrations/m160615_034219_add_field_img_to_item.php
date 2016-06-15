<?php

use yii\db\Migration;

class m160615_034219_add_field_img_to_item extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'img', 'VARCHAR(255) DEFAULT NULL');
    }

    public function down()
    {
    }
}
