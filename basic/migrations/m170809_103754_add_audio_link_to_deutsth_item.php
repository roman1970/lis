<?php

use yii\db\Migration;

class m170809_103754_add_audio_link_to_deutsth_item extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{deutsch_item}}', 'audio_link', 'VARCHAR(225) NOT NULL');

    }

    public function safeDown()
    {
        echo "m170809_103754_add_audio_link_to_deutsth_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170809_103754_add_audio_link_to_deutsth_item cannot be reverted.\n";

        return false;
    }
    */
}
