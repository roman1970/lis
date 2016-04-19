<?php

use yii\db\Migration;

class m160419_080530_create_product_tbl extends Migration
{
    public function up()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'cat_id' => 'INT(11) NOT NULL',
            'price' => 'DECIMAL(10,2)',
            'photo' => 'VARCHAR(255) NOT NULL',
            'description' => 'TEXT NOT NULL'
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB');

        $this->createIndex("ux_products_cat_id", 'products', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{products}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();

        $this->createTable('prod_user', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL',
            'add' => 'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB');


        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'prod_id' => 'INT(11) NOT NULL',
            'date' => 'DATETIME',
            'user_id' => 'INT(11) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB');

        $this->createIndex("ux_orders_prod_id", 'orders', "prod_id", false);
        $this->db->createCommand('ALTER TABLE {{orders}} ADD FOREIGN KEY (`prod_id`) REFERENCES {{products}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();
        $this->createIndex("ux_orders_user_id", 'orders', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{orders}} ADD FOREIGN KEY (`user_id`) REFERENCES {{prod_user}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();

    }

    public function down()
    {
        $this->dropTable('products');
    }
}
