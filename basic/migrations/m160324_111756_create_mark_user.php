<?php

use yii\db\Migration;

class m160324_111756_create_mark_user extends Migration
{
    public function up()
    {
        $this->createTable('mark_user', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(255) NOT NULL',
        ]);


        $this->db->createCommand('ALTER TABLE {{mark_it}} DROP FOREIGN KEY mark_it_ibfk_1;')->execute();
        $this->db->createCommand('ALTER TABLE {{mark_it}} ADD FOREIGN KEY (`user_id`) REFERENCES  {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        $this->dropTable('mark_user');
    }
}
