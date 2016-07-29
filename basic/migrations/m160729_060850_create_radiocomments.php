<?php

use yii\db\Migration;

class m160729_060850_create_radiocomments extends Migration
{
    public function up()
    {
        $this->createTable('radiocomments', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) NOT NULL',
            'body' => 'TEXT NOT NULL',
            'd_created' => 'DATETIME DEFAULT NULL',
            'status' => "enum('new','published','deleted') DEFAULT 'published'",
        ],'DEFAULT CHARSET=utf8 ENGINE = INNODB'
            );

    }

    public function down()
    {
        $this->dropTable('radiocomments');
    }
}
