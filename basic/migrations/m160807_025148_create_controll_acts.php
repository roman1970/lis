<?php

use yii\db\Migration;

class m160807_025148_create_controll_acts extends Migration
{
    public function up()
    {
        $this->createTable('controll_acts', [
            'id' => $this->primaryKey(),
            'time' => 'INT(12) NOT NULL',
            'model_id' => 'INT(8) NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('controll_acts');
    }
}
