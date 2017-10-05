<?php

use yii\db\Migration;

class m170828_011648_add_field_gen_phras_id_to_item extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{items}}', 'phrase_gen_id', 'INT(10) DEFAULT NULL');

        $this->createIndex("ux_items_phrase_gen_id", 'items', "phrase_gen_id", false);
        $this->db->createCommand('ALTER TABLE {{items}} ADD FOREIGN KEY (`phrase_gen_id`) REFERENCES {{items}}(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;')->execute();


    }

    public function safeDown()
    {
        echo "m170828_011648_add_field_gen_phras_id_to_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170828_011648_add_field_gen_phras_id_to_item cannot be reverted.\n";

        return false;
    }
    */
}
