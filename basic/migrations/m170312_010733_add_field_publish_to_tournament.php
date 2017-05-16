<?php

use yii\db\Migration;

class m170312_010733_add_field_publish_to_tournament extends Migration
{
    public function up()
    {
        $this->addColumn('{{foo_tournament}}', 'publish', 'INT(2) DEFAULT 0');

    }

    public function down()
    {
        echo "m170312_010733_add_field_publish_to_tournament cannot be reverted.\n";

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
