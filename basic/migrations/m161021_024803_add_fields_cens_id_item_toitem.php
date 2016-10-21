<?php

use yii\db\Migration;

class m161021_024803_add_fields_cens_id_item_toitem extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'cens', 'INT(2) DEFAULT 0');
        $this->addColumn('{{items}}', 'bind_item_id', 'INT(10) DEFAULT 0');

        $this->createIndex("ux_items_bind_item_id", 'items', "bind_item_id", false);

    }

    public function down()
    {
        echo "m161021_024803_add_fields_cens_id_item_toitem cannot be reverted.\n";

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
