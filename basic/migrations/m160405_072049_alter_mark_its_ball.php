<?php

use yii\db\Migration;

class m160405_072049_alter_mark_its_ball extends Migration
{
    public function up()
    {

        $this->db->createCommand("ALTER TABLE {{mark_it}} MODIFY COLUMN {{ball}} enum('1','2','3','4','5') CHARACTER SET utf8 DEFAULT '1'")->execute();

    }

    public function down()
    {
        echo "m160405_072049_alter_mark_its_ball cannot be reverted.\n";

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
