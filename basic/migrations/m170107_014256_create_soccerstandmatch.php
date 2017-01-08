<?php

use yii\db\Migration;

class m170107_014256_create_soccerstandmatch extends Migration
{
    public function up()
    {
        $this->createTable('soccerstand_match', [
            'id' => $this->primaryKey(),
            'zee' => 'varchar(255) NOT NULL', //Ox0MZaDH
            'zb' => 'INT(8) DEFAULT 0',       //8
            'zy' => 'varchar(255) NOT NULL',  //Мир
            'zс' => 'varchar(255) NOT NULL',  //lhgPuoT8
            'zd' => 'varchar(255) NOT NULL',  //p
            'ze' => 'INT(8) DEFAULT 0',       //0
            'zf' => 'INT(8) DEFAULT 0',       //0
            'zh' => 'varchar(255) NOT NULL',  //8Ox0MZaDH
            'zj' => 'INT(8) DEFAULT 0',       //2
            'zl' => 'varchar(255) NOT NULL',  //rufootballworldclub-friendly
            'zx' => 'varchar(255) NOT NULL',  //00Мир         003......0040000000153000Клубные това026 матчи000
            'zcc' => 'INT(8) DEFAULT 0',      //0
            'aa' => 'varchar(255) NOT NULL',  //b5c1nX1s
            'ad' => 'INT(12) DEFAULT 0',      //1483552800
            'cx' => 'varchar(255) NOT NULL',  //Клаб Африкан (Тун)
            'ax' => 'INT(8) DEFAULT 0',       //1
            'av' => 'INT(12) DEFAULT 0',      //1483562457
            'bx' => 'INT(8) DEFAULT 0',       //-1
            'wn' => 'varchar(255) NOT NULL',  //PSG
            'af' => 'varchar(255) NOT NULL',  //ПСЖ (Фра)
            'wv' => 'varchar(255) NOT NULL',  //paris-sg
            'as' => 'INT(8) DEFAULT 0',      //2
            'az' => 'INT(8) DEFAULT 0',      //2
            'ah' => 'INT(8) DEFAULT 0',      //3
            'bb' => 'INT(8) DEFAULT 0',      //1
            'bd' => 'INT(8) DEFAULT 0',      //2
            'wm' => 'varchar(255) NOT NULL',  //CLU
            'ae' => 'varchar(255) NOT NULL',  //Клаб Африкан (Тун)
            'ag' => 'INT(8) DEFAULT 0',  //0
            'ba' => 'INT(8) DEFAULT 0',  //0
            'bc' => 'INT(8) DEFAULT 0',  //0
            'an' => 'varchar(255) NOT NULL',  //n
            'za' => 'varchar(255) NOT NULL',  //OAЭ
            
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

    }

    public function down()
    {
        $this->dropTable('soccerstand_match');
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
