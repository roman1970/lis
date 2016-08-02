<?php

use yii\db\Migration;

class m160801_073729_add_cash_fields_to_foo_teams extends Migration
{
    public function up()
    {
        $this->addColumn('{{foo_team}}', 'cash_cout', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'cash_vic', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'cash_nob', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'cash_def', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'cash_g_get', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'cash_g_let', 'INT(8)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'cash_balls', 'INT(8)  DEFAULT 0');

    }

    public function down()
    {
    }
}
