<?php

use yii\db\Schema;
use yii\db\Migration;

class m150810_032453_create_table_cities extends Migration
{
    public function up()
    {
	 $this->createTable(
            '{{cities}}', array(
         'id' => 'pk',
         'name' => 'varchar(255) NOT NULL',
         'weather_link' => 'varchar(255) NOT NULL',
         'country_id' => 'INT(11) NOT NULL'
            ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $cityUrls = [
            "http://meteoinfo.ru/pogoda/russia/novosibirsk-area/novosibirsk",
            "http://meteoinfo.ru/pogoda/russia/moscow-area/moscow",
            "http://meteoinfo.ru/pogoda/russia/krasnoyarsk-territory/krasnojarsk",
            "http://meteoinfo.ru/pogoda/russia/astrakhan-area/astrahan",
            "http://meteoinfo.ru/pogoda/russia/republic-altai/gorno-altajsk",
            "http://meteoinfo.ru/pogoda/russia/altai-territory/barnaul",
            "http://meteoinfo.ru/pogoda/russia/republic-bashkortostan/ufa",
            "http://meteoinfo.ru/pogoda/russia/republic-dagestan/mahackala",
            "http://meteoinfo.ru/pogoda/russia/voronezh-area/voronez",
            "http://meteoinfo.ru/pogoda/russia/volgograd-area/volgograd",
            "http://meteoinfo.ru/pogoda/russia/krasnodar-territory/adler",
            "http://meteoinfo.ru/pogoda/russia/kaliningrad-area/kaliningrad",
            "http://meteoinfo.ru/pogoda/russia/kamchatka-area/petropavlovsk-",
            "http://meteoinfo.ru/pogoda/russia/kemerovo-area/kemerovo",
            "http://meteoinfo.ru/pogoda/russia/magadan-area/magadan",
            "http://meteoinfo.ru/pogoda/russia/murmansk-area/murmansk",
            "http://meteoinfo.ru/pogoda/russia/nizhegorodskaya-area/niznij-novgoro",
            "http://meteoinfo.ru/pogoda/russia/novosibirsk-area/culym",
            "http://meteoinfo.ru/pogoda/russia/omsk-area/omsk",
            "http://meteoinfo.ru/pogoda/russia/primorski-krai/vladivostok",
            "http://meteoinfo.ru/pogoda/russia/rostov-area/rostov-na-donu",
            "http://meteoinfo.ru/pogoda/russia/republic-saha-yakutia/jakutsk",
            "http://meteoinfo.ru/pogoda/russia/ryazan-area/rjazan",
            "http://meteoinfo.ru/pogoda/russia/samara-area/samara",
            "http://meteoinfo.ru/pogoda/russia/sverdlovsk-area/ekaterinburg",
            "http://meteoinfo.ru/pogoda/russia/republic-tatarstan/kasan",
            "http://meteoinfo.ru/pogoda/russia/tomsk-area/tomsk",
            "http://meteoinfo.ru/pogoda/russia/khabarovsk-territory/habarovsk",
            "http://meteoinfo.ru/pogoda/russia/hanty-mansijskij-ar/hanty-mansijsk",
            "http://meteoinfo.ru/pogoda/russia/chukotskij-ar/anadyr",
            "http://meteoinfo.ru/pogoda/russia/yaroslavl-area/jaroslavl"
        ];

        foreach ($cityUrls as $url) {
            $parts = explode('/', $url);
            $city = $parts[count($parts)-1];
            $this->insert('cities', ['name' => $city,
                                        'weather_link' => $url]);
        }
 
    }

    public function down()
    {
        echo "m150810_032453_create_table_cities cannot be reverted.\n";

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
