<?php

use yii\db\Migration;

class m160430_131055_add_field_own_id_to_cities extends Migration
{
    public function up()
    {
        $this->addColumn('{{cities}}', 'own_id', 'INT(12) DEFAULT 0');
        $this->addColumn('{{cities}}', 'lon', 'DECIMAL(10, 6) DEFAULT 0');
        $this->addColumn('{{cities}}', 'lat', 'DECIMAL(10, 6) DEFAULT 0');
    }

    public function down()
    {
    }
}
