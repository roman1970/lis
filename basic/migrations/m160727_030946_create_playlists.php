<?php

use yii\db\Migration;

class m160727_030946_create_playlists extends Migration
{
    public function up()
    {
        $this->createTable('playlists', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
        
        
    }

    public function down()
    {
        $this->dropTable('playlists');
    }
}
