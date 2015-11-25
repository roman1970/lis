<?php

use yii\db\Migration;

class m151125_113923_create_table_khl_teams extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{chl_teams}}', array(
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
            'city_id' => 'INT(2) NOT NULL',
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_chl_teams_city_id", '{{chl_teams}}', "city_id", false);
        $this->db->createCommand('ALTER TABLE {{chl_teams}} ADD FOREIGN KEY (`city_id`) REFERENCES  {{cities}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        echo "m151125_113923_create_table_khl_teams cannot be reverted.\n";

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
