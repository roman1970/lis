<?php

use yii\db\Migration;

class m160218_072407_add_field_gk_khl_events extends Migration
{
    public function up()
    {
        $this->addColumn('{{chl_events}}', 'gk', 'INT(4) DEFAULT 0');

    }

    public function down()
    {
        echo "m160218_072407_add_field_gk_khl_events cannot be reverted.\n";

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
    SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE table1;
SET FOREIGN_KEY_CHECKS = 1;
    */
}
