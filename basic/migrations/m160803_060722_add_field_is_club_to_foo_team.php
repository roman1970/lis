<?php

use yii\db\Migration;

class m160803_060722_add_field_is_club_to_foo_team extends Migration
{
    public function up()
    {
        $this->addColumn('{{foo_team}}', 'is_club', 'INT(1)  DEFAULT 1');
    }

    public function down()
    {
    }
}
