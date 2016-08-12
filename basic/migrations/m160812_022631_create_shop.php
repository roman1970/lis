<?php

use yii\db\Migration;

class m160812_022631_create_shop extends Migration
{
    public function up()
    {
        $this->createTable('shop', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
       
    }

    public function down()
    {
        $this->dropTable('shop');
    }
}
