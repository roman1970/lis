<?php

use yii\db\Migration;
use app\components\Helper;

class m160418_035558_create_and_fill_currency_tbls extends Migration
{
    public function up()
    {
        $this->createTable('currencies', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
            'valute_id' => 'VARCHAR(10) NOT NULL',
            'num_code' => 'VARCHAR(10) NOT NULL',
            'char_code' => 'VARCHAR(10) NOT NULL',
        ]);

        $this->createTable('curr_history', [
            'id' => $this->primaryKey(),
            'date' => 'DATETIME',
            'currency_id' => 'INT(8) NOT NULL',
            'nominal' => 'INT(8) DEFAULT 0',
            'value' => 'FLOAT(8) NOT NULL'
        ]);

        $this->createIndex("ux_curr_history_currency_id", 'curr_history', "currency_id", false);
        $this->db->createCommand('ALTER TABLE {{curr_history}} ADD FOREIGN KEY (`currency_id`) REFERENCES  {{currencies}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('currencies');
    }
}
