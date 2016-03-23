<?php

use yii\db\Migration;

class m160323_034522_create_mark_group_tbl extends Migration
{
    public function up()
    {
        $this->createTable('mark_group', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('mark_group');
    }
}
