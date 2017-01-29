<?php

use yii\db\Migration;

class m170126_042734_add_cat_to_quest extends Migration
{
    public function up()
    {
        $this->addColumn('{{test_questions}}', 'cat_id', 'INT(4) NOT NULL');

        $this->createIndex("ux_test_questions_cat_id", 'test_questions', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{test_questions}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();


    }

    public function down()
    {
        echo "m170126_042734_add_cat_to_quest cannot be reverted.\n";

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
