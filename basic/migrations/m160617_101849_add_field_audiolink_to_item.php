<?php

use yii\db\Migration;

class m160617_101849_add_field_audiolink_to_item extends Migration
{
    public function up()
    {
        $this->addColumn('{{items}}', 'audio_link', 'VARCHAR(255) DEFAULT NULL');
    }

    public function down()
    {
    }
}
