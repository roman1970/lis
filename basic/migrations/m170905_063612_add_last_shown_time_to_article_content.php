<?php

use yii\db\Migration;

class m170905_063612_add_last_shown_time_to_article_content extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{qparticles_content}}', 'd_shown', 'INT(12) DEFAULT 0');

    }

    public function safeDown()
    {
        echo "m170905_063612_add_last_shown_time_to_article_content cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170905_063612_add_last_shown_time_to_article_content cannot be reverted.\n";

        return false;
    }
    */
}
