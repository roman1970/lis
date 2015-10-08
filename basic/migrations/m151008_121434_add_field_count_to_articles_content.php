<?php

use yii\db\Schema;
use yii\db\Migration;

class m151008_121434_add_field_count_to_articles_content extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles_content}}', 'count', 'INT(8) DEFAULT 0');

    }

    public function down()
    {
        echo "m151008_121434_add_field_count_to_articles_content cannot be reverted.\n";

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
