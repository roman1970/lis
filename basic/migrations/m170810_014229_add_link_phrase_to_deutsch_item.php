<?php

use yii\db\Migration;

class m170810_014229_add_link_phrase_to_deutsch_item extends Migration
{
    public function safeUp()
    {

        $this->addColumn('{{deutsch_item}}', 'audio_phrase_link', 'VARCHAR(225) NOT NULL');

    }

    public function safeDown()
    {
        echo "m170810_014229_add_link_phrase_to_deutsch_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170810_014229_add_link_phrase_to_deutsch_item cannot be reverted.\n";

        return false;
    }
    */
}
