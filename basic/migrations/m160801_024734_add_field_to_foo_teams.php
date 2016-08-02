<?php

use yii\db\Migration;

class m160801_024734_add_field_to_foo_teams extends Migration
{
    public function up()
    {
        $this->addColumn('{{foo_team}}', 'is_tour_visual', 'INT(1)  DEFAULT 0');
    }

    public function down()
    {
    }
}
