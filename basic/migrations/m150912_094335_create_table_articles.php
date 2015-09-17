<?php

use yii\db\Schema;
use yii\db\Migration;

class m150912_094335_create_table_articles extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{qparticles}}', array(
            'id' => 'pk',
            'title' => 'varchar(255) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'd_created' => 'DATETIME',
            'img' =>  'varchar(255) NOT NULL',
            'anons' => 'TEXT NOT NULL',
            'site_id' => 'INT(11) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );


        $this->createIndex("ux_qparticles_qparticles_site_id", 'qparticles', "site_id", false);
        $this->db->createCommand('ALTER TABLE {{qparticles}} ADD FOREIGN KEY (`site_id`) REFERENCES {{qpsites}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();

    }

    public function down()
    {
        echo "m150912_094335_create_table_articles cannot be reverted.\n";
        //$this->dropTableWithForeignKeys('{{qparticles}}');

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
