<?php

use yii\db\Schema;
use yii\db\Migration;

class m150912_094744_create_table_category extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{qpcategory}}', array(
            'id' => 'pk',
            'title' => 'varchar(255) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
        $this->addColumn('{{qparticles}}', 'cat_id', 'INT(11) NOT NULL');
        $this->createIndex("ux_qparticles_qparticles_cat_id", 'qparticles', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{qparticles}} ADD FOREIGN KEY (`cat_id`) REFERENCES  {{qpcategory}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m150912_094744_create_table_category cannot be reverted.\n";

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
