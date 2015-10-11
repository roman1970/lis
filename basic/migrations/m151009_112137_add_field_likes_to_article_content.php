<?php

use yii\db\Schema;
use yii\db\Migration;

class m151009_112137_add_field_likes_to_article_content extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles_content}}', 'likes', 'INT(8) DEFAULT 0');

    }

    public function down()
    {
        echo "m151009_112137_add_field_likes_to_article_content cannot be reverted.\n";

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
