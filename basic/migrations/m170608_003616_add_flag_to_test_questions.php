<?php

use yii\db\Migration;

class m170608_003616_add_flag_to_test_questions extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{test_questions}}', 'used', 'INT(1) DEFAULT 0');

    }

    public function safeDown()
    {
        echo "m170608_003616_add_flag_to_test_questions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170608_003616_add_flag_to_test_questions cannot be reverted.\n";

        return false;
    }
    */
}
