<?php

use yii\db\Migration;

class m160211_063341_add_fields_to_khl_tables extends Migration
{
    public function up()
    {
        $this->addColumn('{{chl_players}}', 'penalty', 'INT(4) DEFAULT 0');
        $this->addColumn('{{chl_matches}}', 'players', 'VARCHAR(255)');

    }

    public function down()
    {
        echo "m160211_063341_add_fields_to_khl_tables cannot be reverted.\n";

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
