<?php

use yii\db\Schema;
use yii\db\Migration;

class m150906_035958_create_table_qpsites extends Migration
{
    public function up()
    {
       /* $this->createTable(
            '{{qpsites}}', array(
            'id' => 'pk',
            'title' => 'VARCHAR(225)',
            'url' => 'VARCHAR(225)',
            'theme' => 'VARCHAR(225)',
            'user_id' => 'INT(2) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->db->createCommand('ALTER TABLE {{qpsites}} ADD FOREIGN KEY (`user_id`) REFERENCES  {{user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
    */
    }

    public function down()
    {
        echo "m150906_035958_create_table_qpsites cannot be reverted.\n";

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
