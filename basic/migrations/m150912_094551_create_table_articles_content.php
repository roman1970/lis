<?php

use yii\db\Schema;
use yii\db\Migration;

class m150912_094551_create_table_articles_content extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{qparticles_content}}', array(
            'id' => 'pk',
            'articles_id' => 'INT(11) NOT NULL',
            'body' => 'TEXT NOT NULL',
            'minititle' => 'varchar(255) NOT NULL',
            'img' => 'varchar(255) NOT NULL',
            'page' => 'INT(11) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_qparticles_content_articles_id", 'qparticles_content', "articles_id", false);
        $this->db->createCommand('ALTER TABLE {{qparticles_content}} ADD FOREIGN KEY (`articles_id`) REFERENCES  {{qparticles}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        echo "m150912_094551_create_table_articles_content cannot be reverted.\n";
        $this->dropTableWithForeignKeys('{{qparticles_content}}');

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
