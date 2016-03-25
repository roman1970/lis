<?php

use yii\db\Migration;

class m160325_075306_alter_charset_mark_columns extends Migration
{
    public function up()
    {
        $this->db->createCommand('ALTER TABLE {{mark_actions}} MODIFY COLUMN {{name}} VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci;')->execute();
        $this->db->createCommand('ALTER TABLE {{mark_group}}  MODIFY COLUMN {{name}} VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci;')->execute();
        $this->db->createCommand('ALTER TABLE {{mark_user}} MODIFY COLUMN {{name}} VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci;')->execute();
        $this->db->createCommand('ALTER TABLE {{mark_user}} MODIFY COLUMN {{pseudo}} VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci;')->execute();


    }

    public function down()
    {
        echo "m160325_075306_alter_charset_mark_columns cannot be reverted.\n";

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
