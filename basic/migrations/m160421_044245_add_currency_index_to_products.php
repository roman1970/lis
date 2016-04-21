<?php

use yii\db\Migration;

class m160421_044245_add_currency_index_to_products extends Migration
{
    public function up()
    {
        //$this->truncateTable('products');
        $this->db->createCommand("ALTER TABLE {{products}} MODIFY COLUMN {{currency}} INT(4)  DEFAULT 35")->execute();
        $this->createIndex("ux_products_currency", 'products', "currency", false);
        $this->db->createCommand('ALTER TABLE {{products}} ADD FOREIGN KEY (`currency`) REFERENCES  {{currencies}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
