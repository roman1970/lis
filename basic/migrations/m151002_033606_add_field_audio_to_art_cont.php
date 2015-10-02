<?php

use yii\db\Schema;
use yii\db\Migration;

class m151002_033606_add_field_audio_to_art_cont extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles_content}}', 'audio', 'VARCHAR(255) DEFAULT NULL');

    }

    public function down()
    {
        echo "m151002_033606_add_field_audio_to_art_cont cannot be reverted.\n";

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
