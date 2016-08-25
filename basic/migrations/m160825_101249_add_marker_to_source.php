<?php

use yii\db\Migration;

class m160825_101249_add_marker_to_source extends Migration
{
    public function up()
    {
        $this->addColumn('{{sources}}', 'marker', 'VARCHAR(255)');

    }

    public function down()
    {
    }
}
