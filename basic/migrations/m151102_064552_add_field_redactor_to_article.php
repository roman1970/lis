<?php

use yii\db\Migration;

class m151102_064552_add_field_redactor_to_article extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles}}', 'redactor', 'TINYINT(1) DEFAULT 0');

    }

    public function down()
    {
        echo "m151102_064552_add_field_redactor_to_article cannot be reverted.\n";

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
