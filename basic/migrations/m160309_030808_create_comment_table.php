<?php

use yii\db\Migration;

class m160309_030808_create_comment_table extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{qpcomments}}', array(
            'id' => 'pk',
            'name' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) NOT NULL',
            'body' => 'TEXT NOT NULL',
            'd_created' => 'DATETIME DEFAULT NULL',
            'article_content_id' => 'INT(8) NOT NULL',
            'status' => "enum('new','published','deleted') DEFAULT 'published'",
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_qpcomments_article_content_id", 'qpcomments', "article_content_id", false);
        $this->db->createCommand('ALTER TABLE {{qpcomments}} ADD FOREIGN KEY (`article_content_id`) REFERENCES  {{qparticles_content}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        echo "m160309_030808_create_comment_table cannot be reverted.\n";

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
