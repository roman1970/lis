<?php

use yii\db\Migration;

class m170606_035745_create_en_rus_tbl extends Migration
{
    public function safeUp()
    {
        $this->createTable('en_rus', [
            'id' => $this->primaryKey(),
            'en' =>  'VARCHAR(255) NOT NULL',
            'rus' =>  'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function safeDown()
    {
        echo "m170606_035745_create_en_rus_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170606_035745_create_en_rus_tbl cannot be reverted.\n";

        return false;
    }
    */
}
