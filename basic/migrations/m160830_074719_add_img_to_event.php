<?php

use yii\db\Migration;

class m160830_074719_add_img_to_event extends Migration
{
    public function up()
    {
        $this->addColumn('{{events}}', 'img', 'VARCHAR(255)');
    }

    public function down()
    {
    }
}
