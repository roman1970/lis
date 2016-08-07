<?php

use yii\db\Migration;

class m160807_030046_create_ate extends Migration
{
    public function up()
    {
        $this->createTable('ate', [
            'id' => $this->primaryKey(),
            'dish_id' => 'INT(4) NOT NULL',
            'act_id' => 'INT(8) NOT NULL',
            'measure' => 'INT(8) NOT NULL',
            'kkal' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );


    }

    public function down()
    {
        $this->dropTable('ate');
    }
}
