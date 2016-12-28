<?php

use yii\db\Migration;

class m161227_012517_add_fields_to_rec_day_params extends Migration
{
    public function up()
    {
        $this->addColumn('{{day_snapshot}}', 'el112', 'INT(10)  DEFAULT 0');
        $this->addColumn('{{day_snapshot}}', 'el111', 'INT(10)  DEFAULT 0');
        $this->addColumn('{{day_snapshot}}', 'water_cold', 'INT(10)  DEFAULT 0');
        $this->addColumn('{{day_snapshot}}', 'water_hot', 'INT(10)  DEFAULT 0');
        
    }

    public function down()
    {
        echo "m161227_012517_add_fields_to_rec_day_params cannot be reverted.\n";

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
