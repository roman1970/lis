<?php

use yii\db\Schema;
use yii\db\Migration;

class m150927_120157_add_fiels_to_qparticles extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles}}', 'text', 'TEXT');
        $this->addColumn('{{qparticles}}', 'user_id', 'INT(2) NOT NULL');
        $this->addColumn('{{qparticles}}', 'audio', 'VARCHAR(225) NOT NULL');
        $this->addColumn('{{qparticles}}', 'video', 'VARCHAR(225) NOT NULL');
        $this->addColumn('{{qparticles}}', 'status', "ENUM('new','published','deleted') DEFAULT 'published'");

    }

    public function down()
    {
        echo "m150927_120157_add_fiels_to_qparticles cannot be reverted.\n";

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
