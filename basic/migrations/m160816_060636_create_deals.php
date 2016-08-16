<?php

use yii\db\Migration;

class m160816_060636_create_deals extends Migration
{
    public function up()
    {
        $this->createTable('deals', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
            'mark' => 'INT(2) DEFAULT 0',
            'status' => 'INT(2) DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
    }

    public function down()
    {
        $this->dropTable('deals');
    }
}
