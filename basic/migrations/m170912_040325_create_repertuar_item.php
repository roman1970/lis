<?php

use yii\db\Migration;

class m170912_040325_create_repertuar_item extends Migration
{
    public function safeUp()
    {
        $this->createTable('repertuar_item', [
            'id' => $this->primaryKey(),
            'item_reper_id' =>  'INT(8) NOT NULL',
            'item_phrase_id' =>  'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function safeDown()
    {
        echo "m170912_040325_create_repertuar_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170912_040325_create_repertuar_item cannot be reverted.\n";

        return false;
    }
    */
}
