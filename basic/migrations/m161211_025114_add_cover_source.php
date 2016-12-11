<?php

use yii\db\Migration;

class m161211_025114_add_cover_source extends Migration
{
    public function up()
    {
        $this->addColumn('{{sources}}', 'cover', 'VARCHAR(255)  DEFAULT NULL');

    }

    public function down()
    {
        echo "m161211_025114_add_cover_source cannot be reverted.\n";

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
