<?php

use yii\db\Migration;

class m160812_023743_create_bougth extends Migration
{
    public function up()
    {
       
        $this->createTable('bought', [
            'id' => $this->primaryKey(),
            'product_id' => 'INT(4) NOT NULL',
            'act_id' => 'INT(8) NOT NULL',
            'shop_id' => 'INT(8) NOT NULL',
            'user_id' => 'INT(8) NOT NULL',
            'spent' => 'DECIMAL(10,4) DEFAULT 0',
            'item_price' => 'DECIMAL(10,4) DEFAULT 0',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_bought_product_id", 'bought', "product_id", false);
        $this->db->createCommand('ALTER TABLE {{bought}} ADD FOREIGN KEY (`product_id`) REFERENCES {{products}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_bought_act_id", 'bought', "act_id", false);
        $this->db->createCommand('ALTER TABLE {{bought}} ADD FOREIGN KEY (`act_id`) REFERENCES {{controll_acts}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_bought_shop_id", 'bought', "shop_id", false);
        $this->db->createCommand('ALTER TABLE {{bought}} ADD FOREIGN KEY (`shop_id`) REFERENCES {{shop}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
       
      
        $this->createIndex("ux_bought_user_id", 'bought', "user_id", false);
        $this->db->createCommand('ALTER TABLE {{bought}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('bought');
    }
}
