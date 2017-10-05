<?php

use yii\db\Migration;

class m170806_154307_add_shown_to_deutsch_item extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{deutsch_item}}', 'shown', 'INT(1) DEFAULT 0');

    }

    public function safeDown()
    {
        echo "m170806_154307_add_shown_to_deutsch_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170806_154307_add_shown_to_deutsch_item cannot be reverted.\n";

        return false;
    }
    */
}
