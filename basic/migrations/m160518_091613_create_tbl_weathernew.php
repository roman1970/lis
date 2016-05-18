<?php

use yii\db\Migration;

class m160518_091613_create_tbl_weathernew extends Migration
{
    public function up()
    {
        $this->createTable('weathernew', [
            'id' => $this->primaryKey(),
            'main' => 'VARCHAR(255) NOT NULL',
            'description' => 'VARCHAR(255) NOT NULL',
            'icon' => 'VARCHAR(255) NOT NULL',
            'temp' => 'DECIMAL(4, 2) DEFAULT 0',
            'temp_min' => 'DECIMAL(4, 2) DEFAULT 0',
            'temp_max' => 'DECIMAL(4, 2) DEFAULT 0',
            'pressure' => 'INT(8) NOT NULL',
            'humidity' => 'INT(8) NOT NULL',
            'visibility' => 'INT(8) NOT NULL',
            'wind_speed' => 'INT(8) NOT NULL',
            'wind_deg' => 'INT(8) NOT NULL',
            'sea_level' => 'INT(8) NOT NULL',
            'rain_3h' => 'INT(8) NOT NULL',
            'grnd_level' => 'INT(8) NOT NULL',
            'clouds' => 'INT(8) NOT NULL',
            'time' => 'INT(12) NOT NULL',
            'sunrise' => 'INT(12) NOT NULL',
            'sunset' => 'INT(12) NOT NULL',
            'res_code' => 'INT(8) NOT NULL',
            'city_id' => 'INT(8) NOT NULL',
        ]);

        $this->createIndex("ux_weathernew_city_id", 'weathernew', "city_id", false);
        $this->db->createCommand('ALTER TABLE {{weathernew}} ADD FOREIGN KEY (`city_id`) REFERENCES  {{cities}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('tbl_weathernew');
    }
}
