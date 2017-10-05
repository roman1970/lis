<?php

use yii\db\Migration;

class m170606_153653_add_fields_to_en_rus extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{en_rus}}', 'dictionary', 'INT(2) DEFAULT 0');
        $this->addColumn('{{en_rus}}', 'used_test', 'INT(1) DEFAULT 0');

    }

    public function safeDown()
    {
        echo "m170606_153653_add_fields_to_en_rus cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170606_153653_add_fields_to_en_rus cannot be reverted.\n";

        return false;
    }
    */
}
