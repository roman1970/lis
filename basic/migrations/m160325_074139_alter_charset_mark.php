<?php

use yii\db\Migration;

class m160325_074139_alter_charset_mark extends Migration
{
    public function up()
    {
        $this->db->createCommand('ALTER TABLE {{mark_actions}} CHARACTER SET utf8, COLLATE utf8_general_ci;')->execute();
        $this->db->createCommand('ALTER TABLE {{mark_group}}  CHARACTER SET utf8, COLLATE utf8_general_ci;')->execute();
        $this->db->createCommand('ALTER TABLE {{mark_it}} CHARACTER SET utf8, COLLATE utf8_general_ci;')->execute();
        $this->db->createCommand('ALTER TABLE {{mark_user}} CHARACTER SET utf8, COLLATE utf8_general_ci;')->execute();

    }

    public function down()
    {
        echo "m160325_074139_alter_charset_mark cannot be reverted.\n";

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
