<?php

use yii\db\Migration;

class m170131_042155_create_tag_prods extends Migration
{
    public function up()
    {
        $this->createTable('tag_prods', [
            'id' => $this->primaryKey(),
            'prod' =>  'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        echo "m170131_042155_create_tag_prods cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
