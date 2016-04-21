<?php

use yii\db\Migration;

class m160421_065153_alter_products_tbl extends Migration
{
    public function up()
    {
        $this->addColumn('{{products}}', 'currency_out', 'INT(4) DEFAULT 35');
        $this->createIndex("ux_products_currency_out", 'products', "currency_out", false);
        $this->db->createCommand('ALTER TABLE {{products}} ADD FOREIGN KEY (`currency_out`) REFERENCES  {{currencies}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m160421_065153_alter_products_tbl cannot be reverted.\n";

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
