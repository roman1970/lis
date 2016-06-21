<?php

use yii\db\Migration;

class m160621_033229_create_tot_user extends Migration
{
    public function up()
    {

        $this->createTable('tot_user', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'pseudo' => 'VARCHAR(255) NOT NULL',
            'money' => 'DECIMAL(10,4)  DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        $this->dropTable('tot_user');
    }
}
