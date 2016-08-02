<?php

use yii\db\Migration;

class m160801_023152_add_fields_to_foo_teams extends Migration
{
    public function up()
    {
        $this->addColumn('{{foo_team}}', 'country', 'VARCHAR(255)  NOT NULL');
        $this->addColumn('{{foo_team}}', 'alias', 'VARCHAR(255)  NOT NULL');
        $this->addColumn('{{foo_team}}', 'rank', 'DECIMAL(10,4)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'rank1old', 'DECIMAL(10,4)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'rank2old', 'DECIMAL(10,4)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'rank3old', 'DECIMAL(10,4)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'rank4old', 'DECIMAL(10,4)  DEFAULT 0');
        $this->addColumn('{{foo_team}}', 'rank5old', 'DECIMAL(10,4)  DEFAULT 0');

    }

    public function down()
    {
    }
}
