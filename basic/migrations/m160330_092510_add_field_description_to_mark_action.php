<?php

use yii\db\Migration;

class m160330_092510_add_field_description_to_mark_action extends Migration
{
    public function up()
    {
        $this->addColumn('{{mark_actions}}', 'description', 'TEXT');
    }

    public function down()
    {
    }
}
