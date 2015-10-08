<?php

use yii\db\Schema;
use yii\db\Migration;

class m151008_042619_add_field_onepages_to_articles extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles}}', 'onepages', 'INT(2) DEFAULT 1');

    }

    public function down()
    {
        echo "m151008_042619_add_field_onepages_to_articles cannot be reverted.\n";

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
