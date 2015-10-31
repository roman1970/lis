<?php

use yii\db\Schema;
use yii\db\Migration;

class m151027_062610_add_field_siteid_to_cat_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{qpcategory}}', 'site_id', 'INT(11) DEFAULT 4');

        $this->createIndex("ux_qpcategory_qpcategory_site_id", 'qpcategory', "site_id", false);
        $this->db->createCommand('ALTER TABLE {{qpcategory}} ADD FOREIGN KEY (`site_id`) REFERENCES {{qpsites}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();

    }

    public function down()
    {
        echo "m151027_062610_add_field_siteid_to_cat_table cannot be reverted.\n";

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
