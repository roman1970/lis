<?php

use yii\db\Migration;

class m160702_031537_create_football_teams_tbl extends Migration
{
    public function up()
    {
        $this->createTable('football_teams', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'reg' => 'VARCHAR(255) NOT NULL',
            'adapt_name' => 'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        $this->dropTable('football_teams');
    }
}
