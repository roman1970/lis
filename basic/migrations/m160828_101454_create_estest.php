<?php

use yii\db\Migration;

class m160828_101454_create_estest extends Migration
{
    public function up()
    {
        $this->createTable('estest', [
            'id' => $this->primaryKey(),
            'name' => 'varchar(255) NOT NULL',
            'ideal' => 'varchar(255) NOT NULL',
            'real' => 'varchar(255) NOT NULL',
            'description' => 'TEXT DEFAULT NULL',
            'lim_val' => 'DECIMAL(10,4) DEFAULT 0',
            'cat_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_estest_cat_id", 'estest', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{estest}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        $this->dropTable('estest');
    }
}
