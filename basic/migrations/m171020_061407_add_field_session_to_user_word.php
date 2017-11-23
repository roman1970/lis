<?php

use yii\db\Migration;

class m171020_061407_add_field_session_to_user_word extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{user_word}}', 'session_id', 'VARCHAR(255) NOT NULL');

    }

    public function safeDown()
    {
        echo "m171020_061407_add_field_session_to_user_word cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171020_061407_add_field_session_to_user_word cannot be reverted.\n";

        return false;
    }
    */
}
