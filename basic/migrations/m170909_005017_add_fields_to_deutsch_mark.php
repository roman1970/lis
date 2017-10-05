<?php

use yii\db\Migration;

class m170909_005017_add_fields_to_deutsch_mark extends Migration
{
    public function safeUp()
    {

        $this->addColumn('{{deutsch_mark}}', 'time', 'INT(12) DEFAULT 0');
        $this->addColumn('{{deutsch_mark}}', 'word_id', 'INT(8) DEFAULT NULL');

        $this->createIndex("ux_deutsch_mark_word_id", 'deutsch_mark', "word_id", false);
        $this->db->createCommand('ALTER TABLE {{deutsch_mark}} ADD FOREIGN KEY (`word_id`) REFERENCES {{deutsch_item}}(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;')->execute();

    }

    public function safeDown()
    {
        echo "m170909_005017_add_fields_to_deutsch_mark cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170909_005017_add_fields_to_deutsch_mark cannot be reverted.\n";

        return false;
    }
    */
}
